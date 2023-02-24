<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\BecomeInstructor;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentChannel;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ReserveMeeting;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\TicketUser;
use App\Models\Webinar;
use App\PaymentChannels\ChannelManager;
use App\Service\AsaasBank\Asaas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\CoraBank\Credentials;
use Illuminate\Support\Facades\Http;

use MercadoPago\SDK as Mercado;
use MercadoPago\Preference as MercadoPreference;
use MercadoPago\Item as MercadoItem;
use MercadoPago\Payer as MercadoPagoPayer;
use MercadoPago\Payment as MercadoPayment;

class PaymentController extends Controller
{
    protected $order_session_key = 'payment.order_id';

    public function paymentRequest(Request $request)
    {



        $rules = [
            'payment_option' => 'required|in:gateway,credit',
            'payment_type' => 'required_if:payment_option,gateway',
            'order_id' => 'required',
            'full_name' => 'required',
            'identificationType' => 'required',
            'identificationNumber' => 'required',
            'cardholderEmail' => 'required',
            'code_zone' => 'required',
            'phone_number' => 'required',
            'zip_code' => 'required',
            'street_name' => 'required',
            'neigborhood' => 'required',
            'street_number' => 'required',
            'city' => 'required',
            'federal_unit' => 'required',


        ];

        $errorMessages = [
            'payment_option.required' => 'Você deve selecionar a forma de pagamento',
            'full_name.required' => 'O nome é obrigatório.',
            'identificationType.required' => 'O tipo de documento é obrigatório.',
            'identificationNumber.required' => 'O número do documento é obrigatório.',
            'cardholderEmail.required' => 'O email é obrigatório.',
            'code_zone.required' => 'O DDD é obrigatório.',
            'phone_number.required' => 'O número de telefone é obrigatório.',
            'zip_code.required' => 'O CEP é obrigatório.',
            'street_name.required' => 'O nome da rua é obrigatório.',
            'street_number.required' => 'O número da residência é obrigatório.',
            'neigborhood.required' => 'O bairro é obrigatório.',
            'city.required' => 'A cidade é obrigatória.',
            'federal_unit.required' => 'A UF é obrigatória.',
            'payment_type.required_if' => 'Obrigatório selecionar boleto, pix ou cartão.',
            'installments.required' => 'O número de parcelas é obrigatório.',
            'transactionAmount.required' => 'O valor é obrigatório.',
            'paymentMethodId.required' => 'A forma de pagamento é obrigatória.',

        ];

       // dd($request->all());


        $dataValidate = $this->validate($request, $rules, $errorMessages);

        $user = auth()->user();
        $data = $request->all();

        $orderId = $request->input('order_id');

        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();



        if ($order->type === Order::$meeting) {
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
            $reserveMeeting->update(['locked_at' => time()]);
        }


        $user->update([
            'full_name' => $dataValidate['full_name'],
            'docType' => $dataValidate['identificationType'],
            'docNumber' => $dataValidate['identificationNumber'],
            'email' => $dataValidate['cardholderEmail'],
            'mobile_code_area' => $dataValidate['code_zone'],
            'mobile' => $dataValidate['phone_number'],
            'zip_code' => $dataValidate['zip_code'],
            'street_name' => $dataValidate['street_name'],
            'neigborhood' => $dataValidate['neigborhood'],
            'street_number' => $dataValidate['street_number'],
            'city' => $dataValidate['city'],
            'federal_unit' => $dataValidate['federal_unit'],
        ]);



        // Credit payment All Learn
        if ($dataValidate['payment_option'] === 'credit') {

            if ($user->getAccountingCharge() < $order->amount) {
                $order->update([
                    'status' => Order::$fail,
                    'payment_method' => 'credit'
                ]);

                session()->put($this->order_session_key, $order->id);

                return redirect('/payments/status');
            }


            $this->setPaymentAccounting($order, 'credit');

            $order->update([
                'status' => Order::$paid,
                'payment_method' => 'credit'
            ]);

            session()->put($this->order_session_key, $order->id);

            return redirect('/payments/status');
        }


        // Credit Card payment - MP
        if ($data['payment_option'] == 'gateway' and $data['payment_type'] == 'cartao') {

            $order->update([
                'payment_method' => 'payment_channel'
            ]);

           // dump($request->all());

            $description = $this->getDescriptionCourse($order);

            // Mercado
            $access_token = env('MERCADO_PAGO_ACCESS_TOKEN_ID');

            Mercado::setAccessToken($access_token);

            $payment = new MercadoPayment();


            $payment->transaction_amount = $data['MPHiddenInputAmount'];
            $payment->token = $data['MPHiddenInputToken'];
            $payment->description = trim($description);
            $payment->installments = $data['installments'];
            $payment->payment_method_id = $data['MPHiddenInputPaymentMethod'];


            $payer = new MercadoPagoPayer();
            $payer->email = $data['cardholderEmail'];
            $payer->identification = array(
                "type" => $data['identificationType'],
                "number" => $data['identificationNumber']
            );

            $payment->payer = $payer;

            $payment->save();

            if ($payment->status !== "approved") {
               // dd($payment->status);
                $order->update([
                    'status' => Order::$fail,
                    'payment_data' => serialize($payment),
                ]);


                $toastData = [
                    'title' => "Erro",
                    'msg' => "Erro ao processar pagamento, consulte a administradora do cartão de crédito",
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);

            } elseif ($payment->status == "approved") {
                // dd("aprovado");
                $this->setPaymentAccounting($order);
                $order->update([
                    'status' => Order::$paid,
                    'reference_id' => $payment->id,
                    'payment_data' => serialize($payment),
                ]);

                session()->put($this->order_session_key, $order->id);
                return redirect('/payments/status');
            }

            /*  $response = array(
                'status' => $payment->status,
                'status_detail' => $payment->status_detail,
                'id' => $payment->id
            ); */
        }



        if($data['payment_option'] == 'gateway' and $data['payment_type'] == 'boleto'){

            $asaas = new Asaas(env('ASSAS_SECRET_KEY'),
            'producao');

            dd($request->all);
            $courses = $order->orderItems->pluck('webinar_id')->toArray();

            $webinars = Webinar::whereIn('id',$courses)->get()->toArray();

            $description ="\n";

            foreach($webinars as $webinar){

                $description .= $webinar['title'] . ",  R$ " . $webinar['price'] . "\n" ;

            }



            // Cria um novo cliente no Assas
           if(empty($user->assas_id)){

              $dadosCliente = [
                "name" => $data['full_name'],
                "email"=> $data['email'],
                "mobilePhone"=> $data['code_zone'].$data['phone_number'],
                "cpfCnpj"=> $data['docNumber'],
                "postalCode"=> $data['zip_code'],
                "addressNumber"=> $data['street_number'],
                "complement"=> $data['complement']??'',
                "externalReference"=> $user->id,
                "notificationDisabled"=> false,
            ];


            $cliente = $asaas->Cliente()->create($dadosCliente);

            $parts = explode ("_",  $cliente->id);

            $user->update([
                'assas_id' => intval($parts[1]),
            ]);

           }



          // dd($data);
            $dadosCobranca = [
            "customer" => $user->assas_id,
            "billingType"=> "BOLETO",
            "dueDate"=> "2023-03-10",
            "installmentCount"=> $data['invoiceParcelNumber'],
            "installmentValue" => $data['total']/$data['invoiceParcelNumber'],
            "description"=> $description,
            "externalReference"=> "056984",
            "fine"=> [
              "value"=> 1
            ],
            "interest"=> [
              "value"=> 2
            ],
            "postalService"=> false
           ];

          //$cobranca = $asaas->Cobranca()->create($dadosCobranca);

          $invoces = $asaas->Cobranca()->getByCustomer($user->assas_id);

          foreach($invoces->data as $data){
            $user->invoice->create([
                "date_end" => $data->dateCreated,
                "value" => $data->value,
                "installment_number" => $data->installment_number,
                "code_bar" => "asdfasdfasdf",
                "invoice_url" => $data->invoiceUrl,
                "bank_slip_url" => $data->bankSlipUrl,
                "description" => $data->description,
                "fine" => $data->fine->value,
                "interest" => $data->interest->value,
            ]);

          }

           dd($invoces);

           //dd('cheguei');
        }


    }


    private function getDescriptionCourse($order)
    {

        $courses = $order->orderItems->pluck('webinar_id')->toArray();

        $webinars = Webinar::whereIn('id',$courses)->get()->toArray();

        $description ="\n";

        foreach($webinars as $webinar){

            $description .= $webinar['title'] . ",  R$ " . $webinar['price'] . "\n" ;

        }

        return $description;
    }





    public function makePaymentCreditCard($request)
    {
        $access_token = env('MERCADO_PAGO_ACCESS_TOKEN');

        Mercado::setAccessToken($access_token);



        $payment = new MercadoPayment();
        $payment->transaction_amount = (float)$request->transactionAmount;
        $payment->token = $request->token;
        $payment->description = "Curso All Learn";
        $payment->installments = (int)$request->installments;
        $payment->payment_method_id = $request->paymentMethodId;
        $payment->issuer_id = (int)$request->issuer;

        $payment->payer = array(
            "email" => $request->email,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "identification" => array(
                "type" => $request->docType,
                "number" => $request->docNumber
            ),
            "address" => array(
                "zip_code" => $request->zip_code,
                "street_name" => $request->street_name,
                "street_number" => $request->street_number,
                "neigborhood" => $request->neigborhood,
                "city" => $request->city,
                "federal_unit" => $request->federal_unit,
            ),
            "phone" => array(
                "area_code" => $request->code_zone,
                "number" => $request->phone_number,
            )
        );

        $payment->save();
    }

    public function paymentVerify(Request $request, $gateway)
    {
        $paymentChannel = PaymentChannel::where('class_name', $gateway)
            ->where('status', 'active')
            ->first();

        if ($request->isMethod('GET')) {
            try {

                $channelManager = ChannelManager::makeChannel($paymentChannel);
                $order = $channelManager->verify($request);

                return $this->paymentOrderAfterVerify($order);
            } catch (\Exception $exception) {
                $toastData = [
                    'title' => trans('cart.fail_purchase'),
                    'msg' => trans('cart.gateway_error'),
                    'status' => 'error'
                ];
                return redirect('cart')->with(['toast' => $toastData]);
            }
        }

        if ($request->isMethod('POST')) {
            $data = $request->all();

            if (array_key_exists('type', $data)) {

                $channelManager = ChannelManager::makeChannel($paymentChannel);
                $order = $channelManager->verify($request);

                if (!empty($order)) {

                    if ($order->status == Order::$paying) {
                        $this->setPaymentAccounting($order);
                        $order->update(['status' => Order::$paid]);
                    } else {
                        if ($order->type === Order::$meeting) {
                            $orderItem = OrderItem::where('order_id', $order->id)->first();

                            if ($orderItem && $orderItem->reserve_meeting_id) {
                                $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();

                                if ($reserveMeeting) {
                                    $reserveMeeting->update(['locked_at' => null]);
                                }
                            }
                        }
                    }
                }
            }




            return response()->json($data, 200);
        }
    }

    /*
     * | this methode only run for payku.result
     * */
    public function paykuPaymentVerify(Request $request, $id)
    {
        $paymentChannel = PaymentChannel::where('class_name', PaymentChannel::$payku)
            ->where('status', 'active')
            ->first();

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);

            $request->request->add(['transaction_id' => $id]);

            $order = $channelManager->verify($request);

            return $this->paymentOrderAfterVerify($order);
        } catch (\Exception $exception) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return redirect('cart')->with(['toast' => $toastData]);
        }
    }

    private function paymentOrderAfterVerify($order)
    {
        if (!empty($order)) {

            if ($order->status == Order::$paying) {
                $this->setPaymentAccounting($order);
                $order->update(['status' => Order::$paid]);
            } elseif ($order->status == Order::$pending) { //Order waiting payment, clear cart
                Cart::emptyCart($order->user_id);
            } else {
                if ($order->type === Order::$meeting) {
                    $orderItem = OrderItem::where('order_id', $order->id)->first();

                    if ($orderItem && $orderItem->reserve_meeting_id) {
                        $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();

                        if ($reserveMeeting) {
                            $reserveMeeting->update(['locked_at' => null]);
                        }
                    }
                }
            }

            session()->put($this->order_session_key, $order->id);

            return redirect('/payments/status');
        } else {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];

            return redirect('cart')->with($toastData);
        }
    }

    public function setPaymentAccounting($order, $type = null)
    {
        if ($order->is_charge_account) {
            Accounting::charge($order);
        } else {
            foreach ($order->orderItems as $orderItem) {
                $sale = Sale::createSales($orderItem, $order->payment_method);

                if (!empty($orderItem->reserve_meeting_id)) {
                    $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
                    $reserveMeeting->update([
                        'sale_id' => $sale->id,
                        'reserved_at' => time()
                    ]);

                    $reserver = $reserveMeeting->user;

                    if ($reserver) {
                        $this->handleMeetingReserveReward($reserver);
                    }
                }

                if (!empty($orderItem->subscribe_id)) {
                    Accounting::createAccountingForSubscribe($orderItem, $type);
                } elseif (!empty($orderItem->promotion_id)) {
                    Accounting::createAccountingForPromotion($orderItem, $type);
                } elseif (!empty($orderItem->registration_package_id)) {
                    Accounting::createAccountingForRegistrationPackage($orderItem, $type);

                    if (!empty($orderItem->become_instructor_id)) {
                        BecomeInstructor::where('id', $orderItem->become_instructor_id)
                            ->update([
                                'package_id' => $orderItem->registration_package_id
                            ]);
                    }
                } else {
                    // webinar and meeting and product and bundle

                    Accounting::createAccounting($orderItem, $type);
                    TicketUser::useTicket($orderItem);

                    if (!empty($orderItem->product_id)) {
                        $this->updateProductOrder($sale, $orderItem);
                    }
                }
            }
        }

        Cart::emptyCart($order->user_id);
    }

    public function payStatus(Request $request)
    {
        $orderId = $request->get('order_id', null);

        if (!empty(session()->get($this->order_session_key, null))) {
            $orderId = session()->get($this->order_session_key, null);
            session()->forget($this->order_session_key);
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if (!empty($order)) {
            $data = [
                'pageTitle' => trans('public.cart_page_title'),
                'order' => $order,
            ];

            return view('web.default.cart.status_pay', $data);
        }

        return redirect('/panel');
    }

    private function handleMeetingReserveReward($user)
    {
        if ($user->isUser()) {
            $type = Reward::STUDENT_MEETING_RESERVE;
        } else {
            $type = Reward::INSTRUCTOR_MEETING_RESERVE;
        }

        $meetingReserveReward = RewardAccounting::calculateScore($type);

        RewardAccounting::makeRewardAccounting($user->id, $meetingReserveReward, $type);
    }

    private function updateProductOrder($sale, $orderItem)
    {
        $product = $orderItem->product;

        $status = ProductOrder::$waitingDelivery;

        if ($product and $product->isVirtual()) {
            $status = ProductOrder::$success;
        }

        ProductOrder::where('product_id', $orderItem->product_id)
            ->where('buyer_id', $orderItem->user_id)
            ->update([
                'sale_id' => $sale->id,
                'status' => $status,
            ]);

        if ($product and $product->getAvailability() < 1) {
            $notifyOptions = [
                '[p.title]' => $product->title,
            ];
            sendNotification('product_out_of_stock', $notifyOptions, $product->creator_id);
        }
    }
}
