window.onload = function () {

  AOS.init({
    offset: 300,
    anchorPlacement: 'center-bottom'
  });
  lazyload();

  var theButton = document.querySelector('#theButton');
  if(theButton) {
  theButton.addEventListener('click', (e) => {
    console.log("Clicked!");
    var ourRequest = new XMLHttpRequest();
    console.log(e.target);
    var postID = e.target.dataset.parent;
    console.log(postID);
    ourRequest.open('GET', `http://localhost/wordpress/wp-json/wp/v2/media?parent=${postID}`);
    ourRequest.onload = function() {
      if(ourRequest.status >= 200 && ourRequest.status < 400) {
        var data = JSON.parse(ourRequest.responseText);
        console.log(data);
        loadPosts(data);
      }
      else {
        console.log("There was an error with your request.");
      }
    }
    ourRequest.onerror = function() {
      console.log("Connection error");
    };
    ourRequest.send();
  });
}
  //initialize swiper when document ready
  var mySwiper = new Swiper ('.swiper-container', {
    // Optional parameters
    speed: 1500,
    delay: 2000,
    loop: true,
    autoplay: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  })
};

function loadPosts(postsData) {
  var htmlOutput = '';
  for(let i = 0; i<postsData.length; i++) {
    htmlOutput += `<h2> ${postsData[i].title.rendered} </h2>`;
  }
  console.log(htmlOutput);
}

  // Event Listeners 
  if(!document.querySelector(".telephone-number")) {
  }
  else {
    document.querySelector(".telephone-number").addEventListener("click", copy);
  }
  document.getElementById('hamburger').addEventListener('click', handleClick);
  var dropMenu = document.querySelectorAll('.menu-item-has-children');
  var x = window.matchMedia("(min-width: 800px)");

  if(!x.matches) {
  for(let i=0; i<dropMenu.length; i++) {
    dropMenu[i].addEventListener('click',  function(e) {
      var target = e.currentTarget;
      target.querySelector('ul').classList.toggle('active');
});
  }
}

  // Timelines
  var tl = new TimelineMax({paused: true});
  tl.from(".nav-main", 0.6, {
    opacity: 0,
    height: 0,
    display: 'none',
    ease: Power3.easeInOut
  });

  tl.staggerFrom(".menu-item", 0.8, {
    marginLeft: -50,
    opacity:0,
    ease: Power3.easeInOut,
    delay: 0
  }, 0.25);

  // Function Declarations
  function handleClick(event) {
    if(!event.currentTarget.classList.contains('active')) {
    event.currentTarget.classList.toggle('active');
    tl.play().timeScale(1);
    }
    else {
    event.currentTarget.classList.toggle('active');
    tl.reverse().timeScale(2.5);
    }
  }

  // Copy function
  function copy() {
    var theToolTip = document.querySelector('.telephone-tooltip');
    var copyText = document.querySelector("#telephone");
    copyText.select();
    document.execCommand("copy");
    theToolTip.style.animationName = "toolTip";
    setTimeout(() => {
    theToolTip.style.animationName = "none";
    }, 2000);



  }
  


 // List of links
 // If link is hovered, change opacity of others and keep oapcity for link hovered.

