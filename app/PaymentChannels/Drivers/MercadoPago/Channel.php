<?php

namespace App\PaymentChannels\Drivers\MercadoPago;

use App\Models\Order;
use App\Models\PaymentChannel;
use App\PaymentChannels\IChannel;
use Illuminate\Http\Request;
use MercadoPago\SDK as Mercado;
use MercadoPago\Preference as MercadoPreference;
use MercadoPago\Item as MercadoItem;
use MercadoPago\Payer as MercadoPagoPayer;

class Channel implements IChannel
{
    protected $currency;
    protected $public_key;
    protected $access_token;
    protected $client_id;
    protected $client_secret;
    protected $order_session_key;

    /**
     * Channel constructor.
     * @param PaymentChannel $paymentChannel
     */
    public function __construct(PaymentChannel $paymentChannel)
    {
        $this->currency = currency();

        $this->public_key = env('MERCADO_PAGO_PUBLIC_KEY');
        $this->access_token = env('MERCADO_PAGO_ACCESS_TOKEN');
        $this->client_id = env('MERCADO_CLIENT_ID');
        $this->client_secret = env('MERCADO_CLIENT_SECRET');

        $this->order_session_key = 'mercado.payments.order_id';
    }

    public function paymentRequest(Order $order)
    {
        $user = $order->user;

        Mercado::setAccessToken($this->access_token);

        $payer = new MercadoPagoPayer();
        $payer->name = $user->full_name;
        $payer->email = $user->email;
        $payer->phone = array(
            "area_code" => "",
            "number" => $user->mobile
        );

        $orderItems = $order->orderItems;

        $items = [];
        foreach ($orderItems as $orderItem) {
            $item = new MercadoItem();

            $item->id = $orderItem->id;
            $item->title = "All Learn";
            $item->quantity = 1;
            $item->unit_price = $orderItem->total_amount;
            $item->currency_id = $this->currency;

            $items[] = $item;
        }

        $preference = new MercadoPreference();
        $preference->items = $items;
        $preference->payer = $payer;
        $preference->back_urls = $this->makeCallbackUrl($order);
        $preference->auto_return = "approved";


        $preference->notification_url = url("/payments/verify/MercadoPago");
        $preference->external_reference = $order->id;

        $preference->save();

        session()->put($this->order_session_key, $order->id);

//        return $preference->sandbox_init_point;
        $data = [
            'public_key' => $this->public_key,
            'preference_id' => $preference->id,
        ];

        return view('web.default.cart.channels.mercado', $data);
    }

    private function makeCallbackUrl($order)
    {
        return [
            'success' => url("/payments/verify/MercadoPago"),
            'failure' => url("/payments/verify/MercadoPago"),
            'pending' => url("/payments/verify/MercadoPago"),
        ];
    }

    public function verify(Request $request)
    {
        $data = $request->all();

        if (array_key_exists('payment_id', $data))
        {
            $payment = $data['payment_id'];
        }

        if (array_key_exists('data', $data))
        {
            $payment = $data['data']['id'];
        }        

        
        $data = $this->mercadoPagoChecker($payment);


        $status = $data['status']; // approved or pending or in_process

        session()->forget($this->order_session_key);
        $order = Order::where('id', $data['external_reference'])
            ->first();
        $order->update(['reference_id' => $data['id']]);

        if (!empty($order)) {

            if ($order->status == Order::$paid) return $order;

            if (($status == 'approved')) {
                $order->update([
                    'status' => Order::$paying,
                    'payment_data' => json_encode($data),
                ]);

                return $order;
            }

            if (($status == 'pending') or ($status == 'in_process')) {
                $order->update([
                    'status' => Order::$pending,
                    'payment_data' => json_encode($data),
                ]);

                return $order;
            }


            $order->update([
                'status' => Order::$fail,
                'payment_data' => json_encode($data),
            ]);            
        }        
       



        return $order;
    }

    public function mercadoPagoChecker($id)
    {
        $url = 'https://api.mercadopago.com/v1/payments/'.$id;
        $cURLConnection = curl_init();
        curl_setopt($cURLConnection, CURLOPT_URL, $url);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($cURLConnection, CURLOPT_TIMEOUT, 0);
        curl_setopt($cURLConnection, CURLOPT_MAXREDIRS, 10);
        curl_setopt($cURLConnection, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.env('MERCADO_PAGO_ACCESS_TOKEN') ,
        ));

        $MlResponse = json_decode(curl_exec($cURLConnection),true);
        curl_close($cURLConnection);
        
        return $MlResponse;
    }
}
