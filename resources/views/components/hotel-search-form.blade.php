<div class="form-group">
    <label for="destination">Destination</label>
    <input type="text" class="form-control" id="destination" name="destination" value="{{ old('city', $dataIp['city'] ?? '') }}">
</div>
<!--
<div class="form-group">
    <label for="country">Country</label>
    <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $dataIp['country'] ?? '') }}">
</div>
<div class="form-group">
    <label for="state">State</label>
    <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $dataIp['state'] ?? '') }}">
</div>
<div class="form-group">
    <label for="city">City</label>
    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $dataIp['city'] ?? '') }}">
</div>
-->
<div class="form-group">
    <label for="checkInDate">Entry date</label>
    <input type="date" class="form-control" id="checkin_date" name="checkin_date" value="{{ old('checkInDate', $dataIp['checkInDate'] ?? '') }}">
</div>
<div class="form-group">
    <label for="checkOutDate">Departure date</label>
    <input type="date" class="form-control" id="checkout_date" name="checkout_date" value="{{ old('checkOutDate', $dataIp['checkOutDate'] ?? '') }}">
</div>
<button type="submit" class="btn btn-primary">Look for</button>