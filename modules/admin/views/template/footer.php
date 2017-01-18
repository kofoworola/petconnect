</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- jQuery UI 1.10.3 -->
<script src="<?php echo base_url('assets/js/jquery-ui-1.10.3.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.pickmeup.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.textfill.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.text-fill').textfill({maxFontPixels: 20});
    });
</script>
<!-- Bootstrap -->

<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>

<!-- iCheck -->
<script src="<?php echo base_url('assets/js/plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/AdminLTE/app.js') ?>" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUI92co3YBJVxPKwBv-I2wdALEwXtw89U&libraries=places&callback=initAutocomplete"
async defer></script>

<script type="text/javascript">
    var placeSearch, autocomplete;
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        var input = document.getElementsByClassName('address');
        for (i = 0; i < input.length; i++) {
            autocomplete = new google.maps.places.Autocomplete(input[i], {types: ['geocode']});
        }
    }
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                //autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
<script type="text/javascript" src="http://assets.freshdesk.com/widget/freshwidget.js"></script>
<script type="text/javascript">
    FreshWidget.init("", {"queryString": "&widgetType=popup&formTitle=What's+Going+On%3F&submitTitle=Submit&submitThanks=Awesome%2C+we+got+your+message+and+will+be+in+touch+soon!&captcha=yes", "utf8": "✓", "widgetType": "popup", "buttonType": "text", "buttonText": "Need Help?", "buttonColor": "white", "buttonBg": "#6461ab", "alignment": "2", "offset": "235px", "submitThanks": "Awesome, we got your message and will be in touch soon!", "formHeight": "500px", "captcha": "yes", "url": "https://petconnect.freshdesk.com"});
</script>
</body>
</html>