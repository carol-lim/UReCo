document.addEventListener("DOMContentLoaded", function(event) {

  /****** Bar Icon Clicked to show the navbar  ******/
  const showNavbar = (toggleId, navId, bodyId, headerId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId),
    bodypd = document.getElementById(bodyId),
    headerpd = document.getElementById(headerId)

    // Validate that all variables exist
    if(toggle && nav && bodypd && headerpd){
      toggle.addEventListener('click', ()=>{
        // show navbar
        nav.classList.toggle('show')
        // change icon
        toggle.classList.toggle('fa-times')
        // add padding to body
        bodypd.classList.toggle('body-pd')
        // add padding to header
        headerpd.classList.toggle('body-pd')
      })
    }
  }

  showNavbar('header-toggle','nav-bar','body-pd','header')


  /*********************************** Nav-Link Active ***********************************/
  /*  const linkColor = document.querySelectorAll('.nav_link')

  function colorLink(){
    if(linkColor){
      linkColor.forEach(l=> l.classList.remove('active'))
      this.classList.add('active')
      
    }
  }

  linkColor.forEach(l=> l.addEventListener('click', colorLink))*/

  // code to run since DOM is loaded and ready

});