<main class="pt-2 d-flex flex-wrap col-sm-8 mx-auto">
    <div class="fixed-alert-popup col-sm-6">
        <div class="alert alert-clone d-none">
            <span class="alert-content"><strong class="alert-content-status"></strong></span>
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
    </div>
    <button class="btn btn-primary col-sm-2 ml-auto mr-2 h-25 py-2" id="darksky-data-modal-open" data-toggle="modal">Add data</button>
    <section class="dataTable-wrapper mx-auto col-sm-12 mt-2">
        <table class="datatable table table-striped table-bordered">
            <thead>
            <tr>
                <th>User</th>
                <th>Latitude</th>
                <th>Latitude</th>
                <th>Date requested</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>
</main>


<!-- Modal -->
<div class="modal fade" id="darksky-data-modal" tabindex="-1" role="dialog" aria-labelledby="add-darksky-data-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body darksky-data-body">
                <form class="darksky-data-form">
                    <div class="form-group">
                        <label for="lat">Latitude</label>
                        <input type="text" name="lat" class="form-control validate[required,funcCall[validate_coordinates]]" id="lat" placeholder="Enter latitude"
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="lng">Longitude</label>
                        <input type="text" name="lng" class="form-control validate[required,funcCall[validate_coordinates]]" id="lng" placeholder="Enter longitude"
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="date_requested">Date</label>
                        <input type='text' name="date_requested" class="form-control datepicker" placeholder="Enter date">
                    </div>
                </form>
                <div class="read-only-darksky-data d-none">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Time</label>
                            <input type="text" class="form-control" id="time" value="" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label>Icon</label>
                            <input type="text" class="form-control" id="icon" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Summary</label>
                        <input type="text" class="form-control" id="summary" value="" readonly>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Sunrise time</label>
                            <input type="text" class="form-control" id="sunrise_time" value="" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label>Sunset time</label>
                            <input type="text" class="form-control" id="sunset_time" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Highest temperature</label>
                            <input type="text" class="form-control" id="temp_high" value="" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label>Lowest temperature</label>
                            <input type="text" class="form-control" id="temp_low" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Dew point</label>
                            <input type="text" class="form-control" id="dewpoint" value="" readonly>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Humidity</label>
                                <input type="text" class="form-control" id="humidity" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Pressure</label>
                            <input type="text" class="form-control" id="pressure" value="" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label>Windspeed</label>
                            <input type="text" class="form-control" id="windspeed" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Visibility</label>
                        <input type="text" class="form-control" id="visibility" value="" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex">
                <button type="button" class="btn btn-primary mx-auto submit-darksky-data">Submit data</button>
            </div>
        </div>
    </div>
</div>