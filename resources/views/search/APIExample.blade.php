
@push("js")
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>


    const axios = require('axios');

        // Make a request for a user with a given ID
        axios.get({{route("statesApi")}})
            .then(function (response) {
                // handle success
                console.log(response);
                console.log(response.data);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });


    </script>
@endpush

