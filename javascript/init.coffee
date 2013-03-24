"use strict"

$( document ).ready ->
  
  global =
    component:
      settings: -> settings_component()
  
  
  getPage = ( comp ) ->
    if typeof global.component[ comp ] is 'function' then global.component[ comp ]()
  
  
  
  
  
  
  
  
  
  
  settings_component = ->
    
  
  
    
  getPage( $('section[component]').attr( 'component' ) )
  
