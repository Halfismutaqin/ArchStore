<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Province;
use App\Models\City;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        // Mendapatkan ID pengguna yang sedang login
        $getUserID = Auth::id();

        // Mengambil data customer yang terkait dengan pengguna yang sedang login
        $data['myAccount'] = Customer::with('user')->where('id_users', $getUserID)->first();
        // Memeriksa apakah $data['myAccount'] bernilai null
        if (is_null($data['myAccount'])) {
            // Membuat data baru di tabel customers
            $newCustomer = new Customer();
            $newCustomer->id_users = $getUserID;
            // Tambahkan data lain yang diperlukan untuk kolom lainnya di tabel customers
            // $newCustomer->column_name = $value;

            // Menyimpan data baru ke tabel customers
            $newCustomer->save();
            return redirect()->route('account.index');
        }

        // Ambil data untuk dropdown select
        $data['provinces'] = Province::all();
        $data['cities'] = City::where('province_id', $data['myAccount']->province_id)->get(); // Filter cities by the current province
        $data['subdistricts'] = Subdistrict::where('city_id', $data['myAccount']->city_id)->get(); // Filter subdistricts by the current city

        // Debugging untuk melihat hasil query
        // dump($data['myAccount']->user->email);
        // dump($data['myAccount']);

        // Mengirim data ke view
        return view('frontend.account.index', compact('data'));
    }

    public function edit()
    {
        $getUserID = Auth::id();
        $data['myAccount'] = Customer::with('user')->where('id_users', $getUserID)->first();

        // Mengirim data ke view
        return view('frontend.account.index', compact('data'));
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'province_id' => 'required',
            'city_id' => 'required',
            'subdistrict_id' => 'required',
        ]);

        // Mendapatkan ID pengguna yang sedang login
        $getUserID = Auth::id();

        // Mengambil data customer
        $customer = Customer::where('id_users', $getUserID)->first();

        // Update data user
        $customer->user->name = $request->input('name');
        $customer->user->email = $request->input('email');
        $customer->user->save();

        // Update data customer
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $customer->province_id = $request->input('province_id');
        $customer->city_id = $request->input('city_id');
        $customer->subdistrict_id = $request->input('subdistrict_id');
        $customer->save();

        return redirect()->route('account.index')->with('success', 'Profile updated successfully.');
    }
}
