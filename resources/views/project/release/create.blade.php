@extends('layouts.app')
@section('content')
    <h1>Upload</h1>
    <div id="moduploader"></div>

    <script type="text/javascript">
      window.tusToken = "{{ $tusToken }}";
    </script>
    <script src="{{ asset("upload.js") }}"></script>
@endsection