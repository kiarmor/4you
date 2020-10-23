<select name="country" class="form-control">
	<option value=''>-- Выберите страну --</option>
	@foreach (DB::table('countries')->get() as $country)
		<option value='{{ $country->country_code }}' @if (Auth::user()->country_id == $country->id) selected @endif>{{ $country->country_name }}</option>
	@endforeach
</select>
