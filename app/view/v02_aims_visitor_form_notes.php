<div class="form-group card-notes">
    <h4 style="font-weight: bold">Notes</h4>
    <ul>
        <li>Please allow the system to use your current location</li>
        <li>Complete all required fields with precise and correct details especially for ic number and phone number</li>
        <li>Only accounts that have been verified will be permitted to clock in</li>
    </ul>
</div>

<script>
    $('#ic_number').on('change', function (){
        let yearNow = new Date().getFullYear().toString(); //2023
        let decade = yearNow.substr(0, 2); //2023 -> 20
        let twoDigitYear = $(this).val().substr(0, 2); //990910115217 -> 99
        let birthYear = (yearNow.substr(2,2) > twoDigitYear)
            ? parseInt(decade.concat(twoDigitYear.toString()), 10)
            : "19"+twoDigitYear;
        $('#birth_year').val(birthYear);
    })
</script>