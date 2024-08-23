@extends('layouts.frontend.app')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Account Setting</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Profile Update Form Begin -->
    <section class="account-setting spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4>Update Profile</h4>
                    <hr>
                    <form action="{{ route('account.update') }}" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-lg-11">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" minlength="3"
                                            value="{{ $data['myAccount']->user->name }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $data['myAccount']->user->email }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="province_id" class="col-sm-3 col-form-label">Provinsi</label>
                                    <div class="col-sm-9">
                                        <select id="province_id" name="province_id" class="form-control" required>
                                            <option value="">Select Province</option>
                                            @foreach ($data['provinces'] as $province)
                                                <option value="{{ $province->province_id }}"
                                                    {{ $province->province_id == $data['myAccount']->province_id ? 'selected' : '' }}>
                                                    {{ $province->province_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="city_id" class="col-sm-3 col-form-label">Kabupaten/Kota</label>
                                    <div class="col-sm-9">
                                        <select id="city_id" name="city_id" class="form-control" required>
                                            <option value="">Select City</option>
                                            @foreach ($data['cities'] as $city)
                                                <option value="{{ $city->city_id }}"
                                                    {{ $city->city_id == $data['myAccount']->city_id ? 'selected' : '' }}>
                                                    {{ $city->city_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="subdistric_id" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <select id="subdistrict_id" name="subdistrict_id" class="form-control" required>
                                            <option value="">Select Subdistrict</option>
                                            @foreach ($data['subdistricts'] as $subdistrict)
                                                <option value="{{ $subdistrict->subdistrict_id }}"
                                                    {{ $subdistrict->subdistrict_id == $data['myAccount']->subdistrict_id ? 'selected' : '' }}>
                                                    {{ $subdistrict->subdistrict_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="phone" class="col-sm-3 col-form-label">No Telepon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $data['myAccount']->phone }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 col-form-label">Alamat Lengkap</label>
                                    <div class="col-sm-9">
                                        <textarea name="address" id="address" rows="6" class="form-control" style="height: 72px" placeholder="Isikan alamat lengkap, patokan atau gedung" required>{{ $data['myAccount']->address }}</textarea>
                                    </div>
                                </div>

                            </div>

                        </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
        </div>
    </section>
    <!-- Profile Update Form End -->

    <!-- JavaScript for Dynamic Dropdowns -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province_id');
            const citySelect = document.getElementById('city_id');
            const subdistrictSelect = document.getElementById('subdistrict_id');

            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;

                // Clear existing options
                citySelect.innerHTML = '<option value="">Select City</option>';
                subdistrictSelect.innerHTML = '<option value="">Select Subdistrict</option>';

                if (provinceId) {
                    fetch(`/api/cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.city_id;
                                option.textContent = city.city_name;
                                citySelect.appendChild(option);
                            });
                        });
                }
            });

            citySelect.addEventListener('change', function() {
                const cityId = this.value;

                // Clear existing options
                subdistrictSelect.innerHTML = '<option value="">Select Subdistrict</option>';

                if (cityId) {
                    fetch(`/api/subdistricts/${cityId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.subdistricts.forEach(subdistrict => {
                                const option = document.createElement('option');
                                option.value = subdistrict.subdistrict_id;
                                option.textContent = subdistrict.subdistrict_name;
                                subdistrictSelect.appendChild(option);
                            });
                        });
                }
            });
        });
    </script>
@endsection
