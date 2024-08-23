<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Feature\Cart;
use App\Models\Setting\ShippingAddress;
use App\Models\Customer;
use App\Models\Province;
use App\Models\City;
use App\Models\Subdistrict;
use App\Repositories\CrudRepositories;
use App\Services\Feature\CartService;
use App\Services\Feature\CheckoutService;
use App\Services\Rajaongkir\RajaongkirService;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    protected $rajaongkirService,$checkoutService,$cartService;
    public function __construct(RajaongkirService $rajaongkirService,CheckoutService $checkoutService,CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->rajaongkirService = $rajaongkirService;
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        // Mendapatkan ID pengguna yang sedang login
        $getUserID = Auth::id();
        $data['carts'] = $this->cartService->getUserCart();
        $data['provinces'] = $this->rajaongkirService->getProvince();
        $data['shipping_address'] = ShippingAddress::first();

        // Mengambil data customer yang terkait dengan pengguna yang sedang login
        $data['myAccount'] = Customer::with('user')->where('id_users', $getUserID)->first();

        // Ambil data untuk dropdown select (data option dari database, belum ada ongkir):
        $data['option_provinces'] = Province::all();
        if (!empty($data['myAccount']->province_id)) {
            $data['option_cities'] = City::where('province_id', $data['myAccount']->province_id)->get(); // Filter cities by the current province
            $data['option_subdistricts'] = Subdistrict::where('city_id', $data['myAccount']->city_id)->get(); // Filter subdistricts by the current city
        }

        return view('frontend.checkout.index',compact('data'));
    }

    public function process(Request $request)
    {
        try{
            $this->checkoutService->process($request->all());
            return redirect()->route('transaction.index')->with('success',__('message.order_success'));
        }catch(Exception $e){
            dd($e);
        }
    }
}
