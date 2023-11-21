<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" class="form-control" name="site_name" value="{{ $setting->site_name }}">
                </div>
                <div class="form-group">
                    <label for="inputState">Layout</label>
                    <select id="inputState" class="form-control" name="layout">
                        <option {{ $setting->layout === 'LTR' ? 'selected' : '' }} value="LTR">LTR</option>
                        <option {{ $setting->layout === 'RTL' ? 'selected' : '' }} value="RTL">RTL</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Contact Email</label>
                    <input type="text" class="form-control" name="contact_email"
                        value="{{ $setting->contact_email }}">
                </div>
                <div class="form-group">
                    <label for="inputState">Default Currency Name</label>
                    <select id="inputState" class="form-control select2" name="currency_name">
                        @foreach (config('setting.currency_list') as $key => $currency)
                            <option {{ $setting->currency_name === $currency ? 'selected' : '' }}
                                value="{{ $currency }}">{{ $currency }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Currency Icon</label>
                    <input type="text" class="form-control" name="currency_icon"
                        value="{{ $setting->currency_icon }}">
                </div>
                <div class="form-group">
                    <label for="inputState">Timezone</label>
                    <select id="inputState" class="form-control select2" name="timezone">
                        @foreach (config('setting.timezone') as $key => $val)
                            <option {{ $setting->timezone === $key ? 'selected' : '' }} value="{{ $key }}">
                                {{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
