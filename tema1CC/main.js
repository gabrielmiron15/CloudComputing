console.log('merge');
var yandexApiKey = "trnsl.1.1.20180227T140201Z.acb727c45e012e39.aea5a6d619f3c736d00b47f881b70ca2c16e6b4b";
var proxy = 'https://cors-anywhere.herokuapp.com/';
window.onload = function () {
    $('.input-search').keypress(function (e) {
        if (e.which == 13) {
            var data = $('.input-search').val();
            console.log('You pressed enter!', data);
            data !== '' ? makeStuff($('.input-search').val()) : alert('Trebuie sa completati campul cu un cuvant!')
        }
    });
    $('.button-search').on('click', function () {
        var data = $('.input-search').val();
        data !== '' ? makeStuff($('.input-search').val()) : alert('Trebuie sa completati campul cu un cuvant!')
    })
    $('.title').on('click', function (e) {
        $(this).hasClass('title--active') ? $(this).removeClass('title--active') : $(this).addClass('title--active');
        $(this).next().slideToggle();
    })

};

function makeStuff(data) {
    getDataYandex(data);
    dexOnline(data);
    alert('Done!')
}

function wikiRo(data) {

    $.ajax({
        type: 'GET',
        url: proxy + "http://ro.wikipedia.org/w/api.php",
        data: {
            action: 'parse',
            format: 'json',
            prop: 'text',
            section: '0',
            page: data

        },
        success: function (response) {
            console.log(response);
            typeof response.parse !== 'undefined' ? $('.wiki-ro').html(' ').append(response.parse.text['*']) : $('.wiki-ro').html(' ').append('No results');
        },
        error: function (response) {
            console.log('error')
        }
    });
}

function wikiEn(data) {
    $.ajax({
        type: 'GET',
        url: proxy + "http://en.wikipedia.org/w/api.php",
        data: {
            action: 'parse',
            format: 'json',
            prop: 'text',
            section: '0',
            page: data

        },
        success: function (response) {
            console.log(response);
            typeof response.parse !== 'undefined' ? $('.wiki-en').html(' ').append(response.parse.text['*']) : $('.wiki-en').html(' ').append('No results');
        },
        error: function (response) {
            console.log('error')
        }
    });
}

function dexOnline(data) {
    $.ajax({
        type: 'GET',
        url: proxy + "https://dexonline.ro/definitie/" + data,
        data: {
            format: 'json'
        },
        headers: {
            'Access-Control-Allow-Origin': '*'
        },
        success: function (response) {
            console.log(response)
            typeof response.definitions["0"].htmlRep !== 'undefined' ? $('.dex').html(' ').append(response.definitions["0"].htmlRep) : $('.dex').html(' ').append('No results');
            typeof response.word !== 'undefined' ? wikiRo(response.word) : wikiRo('');
        },
        error: function (response) {
            console.log('error')
            $('.dex').html(' ').append('No results');
        }
    });
}

function getDataYandex(data) {
    $.ajax({
        url: "https://translate.yandex.net/api/v1.5/tr.json/translate",
        data: {
            key: yandexApiKey,
            text: data,
            lang: 'ro-en'
        },
        success: function (response) {
            console.log(response);
            text = response.text[0];
            typeof response.text !== 'undefined' ? ($('.translate-en').html(' ').append(response.text[0])) : $('.translate-en').html(' ').append('No results');
            typeof response.text !== 'undefined' ? wikiEn(response.text[0]) : wikiEn('asdfasf');
            ;
        },
        error: function () {
            console.log('error Yandex api')
            $('.translate-en').html(' ').append('No results');
            wikiEn('asdfasf');
        }
    });
}