@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            @if($entered->title)
                Редактировать
            @else 
                Добавить
            @endif
        </div>
        <div class="panel-body">
            {!! Form::open(['files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('title', 'Заголовок *') !!}
                    {!! Form::text('title', $entered->title, ["class" => "form-control"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('text', 'Текст *') !!}
                    {!! Form::textarea('text', $entered->text, ["class" => "js-redactor", "rows" => 20]) !!}
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox--textless">
                        {!! Form::checkbox('recommended', 1, $entered->recommended) !!}
                        <span>Рекомендуемое</span>
                    </label>
                </div>
                <div class="form-group">
                    {!! Form::label('lang', 'Язык') !!}
                    {!! Form::select('lang', [
                            'ru' => 'Рус',
                            'uz' => 'Узб'
                        ], $entered->lang, [
                            'class' => 'form-control'
                        ])
                    !!}
                </div>
                <div class="form-group">
                    <p>{!! Form::label('category[]', 'Категория') !!}</p>
                  
                    @foreach($categories as $category)
                        <label class="checkbox checkbox--textless mr-10">
                            {!! Form::checkbox('category[]', $category->id, in_array($category->id, $entered_categories)) !!}
                            <span>{{ $category->name_ru }}</span>
                        </label>
                    @endforeach
                </div>
                @if($entered->id && Upload::hasFile('blog', $entered->id)) 
                    <div class="form-group">
                        {!! Upload::getImage('blog', $entered->id, 'img-thumbnail img-h-300') !!}
                    </div>
                @endif
                <div class="form-group">
                    {!! Form::label('photo', 'Фото') !!}
                    {!! Form::file('photo') !!}
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('meta_description', 'Meta description (от 50 до 160 символов)') !!}
                            {!! Form::text('meta_description', $entered->meta_description, ["class" => "form-control"]) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('meta_keywords', 'Meta keywords - (не должен превышать 160 символов)') !!}
                            {!! Form::text('meta_keywords', $entered->meta_keywords, ["class" => "form-control"]) !!}
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ action('Backend\BlogController@index') }}" class="btn btn-default">Отменить</a>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="box">
        <small>
            <p>
                <strong>Meta description</strong> имеет небольшое влияние на ранжирование сайта по поисковому запросу, однако с большой вероятностью выводится в качестве сниппета в выдаче ПС, если в нем присутствуют слова из поискового запроса. Привлекательный сниппет в свою очередь повышает вероятность перехода на страницу из результатов поиска. Мета-теги Description не должны повторяться в пределах сайта и не должны быть как слишком короткими, так и слишком длинными, рекомендованный диапазон длинны содержимого мета-тега Description от 50 до 160 символов.
            </p>
            <p>
                <strong>Meta keywords</strong> не участвует в ранжировании сайта по поисковому запросу, однако его все-равно следует использовать в коде страниц сайта. Мета-тег Keywords должен содержать: 4-10 ключевых слова для страницы, перечисленные через запятую, при этом не должен превышать 160 символов.
            </p>
        </small>
    </div>
@endsection

@section('styles')
<style>
    .img-h-300 {
        height: 300px !important;
    }
</style>
@endsection

@section('scripts')
<script>
    initRedactor();
</script>
@endsection