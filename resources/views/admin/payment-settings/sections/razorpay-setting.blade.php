<div class="tab-pane fade" id="list-razorpay" role="tabpanel" aria-labelledby="list-razorpay-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.razorpay-setting.update', 1) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="inputState">RazorPay status</label>
                    <select id="inputState" class="form-control" name="status">
                        <option {{ $razorpaySetting->status === 0 ? 'selected' : '' }} value="0">Disable</option>
                        <option {{ $razorpaySetting->status === 1 ? 'selected' : '' }} value="1">Enable</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputState">Country name</label>
                    <select id="" class="form-control select2" name="country_name">
                        @foreach (config('setting.country_list') as $country)
                            <option {{ $razorpaySetting->country_name === $country ? 'selected' : '' }}
                                value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputState">Currency name</label>
                    <select id="" class="form-control select2" name="currency_name">
                        @foreach (config('setting.currency_list') as $key => $currency)
                            <option {{ $razorpaySetting->currency_name === $currency ? 'selected' : '' }}
                                value="{{ $currency }}">{{ $currency }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Currency rate (Per {{ $settings->currency_icon }})</label>
                    <input type="text" class="form-control" name="currency_rate"
                        value="{{ $razorpaySetting->currency_rate }}">
                </div>

                <div class="form-group">
                    <label>RazorPay Key</label>
                    <input type="text" class="form-control" name="razorpay_key"
                        value="{{ $razorpaySetting->razorpay_key }}">
                </div>
                <div class="form-group">
                    <label>RazorPay Secret key</label>
                    <input type="text" class="form-control" name="razorpay_secret_key"
                        value="{{ $razorpaySetting->razorpay_secret_key }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
