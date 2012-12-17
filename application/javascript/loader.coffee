js = '/application/javascript/'
css = '/application/css/'

Modernizr.load
    load: 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js',
    complete: ->
      Modernizr.load
        test: window.jQuery
        nope: "#{js}jquery-1.8.3.js"
        both: [ "#{js}init.js" ]
  