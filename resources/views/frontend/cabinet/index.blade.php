@extends('layouts.frontend')

@section('content')
<div id="cabinet"></div>
@endsection

@section('scripts')
<script>
	window.trans = <?php
		// copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
	    $lang_files = File::glob(resource_path('lang/' . App::getLocale() . '/cabinet.php'));
	    $trans = [];
	    foreach ($lang_files as $f) {
	        $filename = basename($f, '.php');
	        $trans[$filename] = trans($filename);
	    }
	    echo json_encode($trans);
	?>;
	window.lang = '{{ App::getLocale() }}';

	window.userInfo = {!! json_encode($user) !!};
</script>
<script src="{{ asset('assets/js/cabinet.js') }}"></script>
@endsection