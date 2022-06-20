@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <div id="output"></div>
                        <form class="form" enctype="multipart/form-data" id="upload_form" method="post">
                            <input type="file" required name="file" id="file" class="form-control">
                            <button class="btn btn-success mt-4" type="submit" id="upload">Upload!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function () {
            let output = document.getElementById('output');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#upload_form').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    method: 'POST',
                    url: "{{route('imageUpload')}}",
                    enctype: 'multipart/form-data',
                    data: new FormData(this),
                    dataType:'JSON',
                    processData: false,  // tell jQuery not to process the data
                    contentType: false
                }).done(function (response) {
                    output.innerHTML = response.url;
                    $('#file').val('');
                }).fail(function (error) {
                    console.log(error);
                })
            })
        })();
    </script>
@endsection
