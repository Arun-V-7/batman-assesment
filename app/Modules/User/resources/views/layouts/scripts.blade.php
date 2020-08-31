<script language="JavaScript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>


<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showLoader(value) {
        $('.'+value).removeClass('hide');
    }

    function hideLoader(value) {
        $('.'+value).addClass('hide');
    }
</script>
