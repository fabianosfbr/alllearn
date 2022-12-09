<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\BecomeInstructor;
use App\Models\Cart;
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
use App\PaymentChannels\ChannelManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
            'payment_option'=> 'required|in:gateway,credit',
            'payment_type'=> 'required_if:payment_option,gateway',
            'order_id' => 'required',
            'full_name' => 'required',
            'docType' => 'required',
            'docNumber' => 'required',
            'email' => 'required',
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
            'docType.required' => 'O tipo de documento é obrigatório.',
            'docNumber.required' => 'O número do documento é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'code_zone.required' => 'O DDD é obrigatório.',
            'phone_number.required' => 'O número de telefone é obrigatório.',
            'zip_code.required' => 'O CEP é obrigatório.',
            'street_name.required' =>'O nome da rua é obrigatório.',
            'street_number.required' => 'O número da residência é obrigatório.',
            'neigborhood.required' => 'O bairro é obrigatório.',
            'city.required' => 'A cidade é obrigatória.',
            'federal_unit.required' => 'A UF é obrigatória.',
            'payment_type.required_if' => 'Obrigatório selecionar boleto, pix ou cartão.',
            'installments.required' => 'O número de parcelas é obrigatório.',
            'transactionAmount.required' =>'O valor é obrigatório.',
            'paymentMethodId.required' => 'A forma de pagamento é obrigatória.',

        ];




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
            'docType' => $dataValidate['docType'],
            'docNumber' => $dataValidate['docNumber'],
            'email' => $dataValidate['email'],
            'code_zone' => $dataValidate['code_zone'],
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
                $order->update(['status' => Order::$fail]);

                session()->put($this->order_session_key, $order->id);

                return redirect('/payments/status');
            }

            $order->update([
                'payment_method' => Order::$credit
            ]);

            $this->setPaymentAccounting($order, 'credit');

            $order->update([
                'status' => Order::$paid
            ]);

            session()->put($this->order_session_key, $order->id);

            return redirect('/payments/status');
        }


        // Credit Card payment - MP
        if($data['payment_option'] == 'gateway' and $data['payment_type'] == 'cartao'){

            $order->payment_method = Order::$paymentChannel;
            $order->save();
            try {


                // Mercado
                //https://www.mercadopago.com.br/developers/pt/docs/checkout-api-v1/receiving-payment-by-card


                $access_token = env('MERCADO_PAGO_ACCESS_TOKEN');
                Mercado::setAccessToken($access_token);

                $payment = new MercadoPayment();
                $payment->transaction_amount = (float)$data['transactionAmount'];
                $payment->token = $data['token'];
                $payment->description = "Curso All Learn";
                $payment->installments = (int)$data['installments'];
                $payment->payment_method_id = $data['paymentMethodId'];
                $payment->issuer_id = (int)$data['issuer'];
                $payment->notification_url = url("/payments/verify/MercadoPago");

                $parts = explode(" ", $data['full_name']);
                if(count($parts) > 1) {
                    $lastname = array_pop($parts);
                    $firstname = implode(" ", $parts);
                }
                else
                {
                    $firstname = $name;
                    $lastname = " ";
                }

                $payment->payer = array(
                    "email" => $data['email'],
                    "first_name" => $firstname,
                    "last_name" => $lastname,
                    "identification" => array(
                        "type" => $data['docType'],
                        "number" => $data['docNumber']
                    ),
                    "address" => array(
                        "zip_code" => $data['zip_code'],
                        "street_name" => $data['street_name'],
                        "street_number" => $data['street_number'],
                        "neigborhood" => $data['neigborhood'],
                        "city" => $data['city'],
                        "federal_unit" => $data['federal_unit'],
                    ),
                    "phone" => array(
                        "area_code" => $data['code_zone'],
                        "number" => $data['phone_number'],
                    )
                );




                dd($payment->save());

            } catch (\Exception $exception) {

                dd($exception->getMessage());
/*                 $toastData = [
                    'title' => trans('cart.fail_purchase'),
                    'msg' => trans('cart.gateway_error'),
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]); */
            }

        }

        if(isset($data->boleto) and $data->boleto == 'on' ){

        }

        try {

            // Cartao Mercado Pago
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $redirect_url = $channelManager->paymentRequest($order);

            if (in_array($paymentChannel->class_name, PaymentChannel::$gatewayIgnoreRedirect)) {
                return $redirect_url;
            }

            return Redirect::away($redirect_url);
        } catch (\Exception $exception) {

            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }
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
