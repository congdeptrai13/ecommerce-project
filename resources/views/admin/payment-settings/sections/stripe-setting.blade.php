<div class="tab-pane fade" id="list-stripe" role="tabpanel" aria-labelledby="list-stripe-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.stripe-setting.update', 1) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="inputState">Stripe status</label>
                    <select id="inputState" class="form-control" name="status">
                        <option {{ $stripeSetting->status === 0 ? 'selected' : '' }} value="0">Disable</option>
                        <option {{ $stripeSetting->status === 1 ? 'selected' : '' }} value="1">Enable</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputState">Account Mode</label>
                    <select id="" class="form-control" name="mode">
                        <option {{ $stripeSetting->mode === 0 ? 'selected' : '' }} value="0">Sandbox</option>
                        <option {{ $stripeSetting->mode === 1 ? 'selected' : '' }} value="1">Live</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputState">Country name</label>
                    <select id="" class="form-control select2" name="country_name">
                        @foreach (config('setting.country_list') as $country)
                            <option {{ $stripeSetting->country_name === $country ? 'selected' : '' }}
                                value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputState">Currency name</label>
                    <select id="" class="form-control select2" name="currency_name">
                        @foreach (config('setting.currency_list') as $key => $currency)
                            <option {{ $stripeSetting->currency_name === $currency ? 'selected' : '' }}
                                value="{{ $currency }}">{{ $currency }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Currency rate (Per {{ $settings->currency_icon }})</label>
                    <input type="text" class="form-control" name="currency_rate"
                        value="{{ $stripeSetting->currency_rate }}">
                </div>
                <div class="form-group">
                    <label>Stripe Client Id</label>
                    <input type="text" class="form-control" name="client_id"
                        value="{{ $stripeSetting->client_id }}">
                </div>
                <div class="form-group">
                    <label>Stripe Secret key</label>
                    <input type="text" class="form-control" name="secret_key"
                        value="{{ $stripeSetting->secret_key }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
