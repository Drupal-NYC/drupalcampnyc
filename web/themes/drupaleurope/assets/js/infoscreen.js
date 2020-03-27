function updateProgram() {
  var sessions = document.querySelectorAll(".view-id-room .views-row");
  if (sessions.length == 0) {
    // If no sessions found (such as OWL page), do nothing here.
    return;
  }

  // Drop all sessions from page markup once their end time has passed.
  for (var i = 0; i < sessions.length; i++) {
    var endTime = new Date(sessions[i].querySelector('.views-field-field-ends-at time').getAttribute('datetime').replace('Z', ''))
    if (endTime < new Date()) {
      document.querySelector('.view-id-room .view-content').removeChild(sessions[i]);
    }
  }

  // Prepare to replace title above "Current" session to reflect current time.
  var currentSession = document.querySelector(".view-id-room .views-row");
  var startTime = new Date(currentSession.querySelector('.views-field-field-start time').getAttribute('datetime').replace('Z', ''));

  // Find or create title holder element as needed.
  var titleHolder = currentSession.querySelector(".views-row-first-header");
  if (titleHolder == null) {
    titleHolder = document.createElement('div');
    titleHolder.className = 'views-row-first-header';
    currentSession.insertBefore(titleHolder, currentSession.querySelector(".views-field-title"));
  }

  // Use title holder element text to represent time to go or time spent since
  // a program item. This helps identify when will something start in a break
  // or when a BoF room has empty slots. Also helps show how much is into
  // the current session already.

  var now = new Date();
  if (startTime > now) {
    var timeToGo = Math.floor((startTime - now) / 1000);
    if (timeToGo < 120) {
      // Last two minutes.
      titleHolder.innerHTML = 'Starts about now';
    }
    else if (timeToGo < 60*60*2) {
      // For the last two hours.
      titleHolder.innerHTML = 'In ' + Math.floor(timeToGo/60) + ' minutes';
    }
    else if (timeToGo < 60*60*48) {
      // Less than 24 hours to.
      titleHolder.innerHTML = 'In ' + Math.floor(timeToGo/(60*60)) + ' hours';
    }
    else {
      // More than 24 hours to.
      titleHolder.innerHTML = 'In ' + Math.floor(timeToGo/(60*60*24)) + ' days';
    }
  }
  else {
    var timeSpent = Math.floor((now - startTime) / 1000);
    if (timeSpent < 120) {
      // First two minutes.
      titleHolder.innerHTML = 'Started just now';
    }
    else if (timeSpent < 60*60*2) {
      // For the first two hours.
      titleHolder.innerHTML = 'Started ' + Math.floor(timeSpent/60) + ' minutes ago';
    }
    else {
      titleHolder.innerHTML = 'Started ' + Math.floor(timeSpent/(60*60)) + ' hours ago';
    }
  }
}

function initNews() {
  var articles = document.querySelectorAll(".view-infoscreen-announcements .views-row");
  if (articles.length < 2) {
    // If less than 2 announcements found (such as OWL page), do nothing here.
    return;
  }
  var container = document.querySelector(".view-infoscreen-announcements");
  var dots = document.createElement('div');
  dots.className = 'newsdots';

  articles[0].style.display = 'block';
  dots.innerHTML = '&bull; ';
  for (var i = 1; i < articles.length; i++) {
    dots.innerHTML += '&bull; ';
    articles[i].style.display = 'none';
  }
  container.insertBefore(dots, container.querySelector(".views-content"));
}

function updateNews() {
  var articles = document.querySelectorAll(".view-infoscreen-announcements .views-row");
  if (articles.length < 2) {
    // If less than 2 announcements found (such as OWL page), do nothing here.
    return;
  }

  // Swap news to the next one available, cycle around.
  for (var i = 0; i < articles.length; i++) {
    if (articles[i].style.display == 'block') {
      articles[i].style.display = 'none';
      if (i < (articles.length - 1)) {
        articles[i+1].style.display = 'block';
      }
      else {
        articles[0].style.display = 'block';
      }
      break;
    }
  }
}

function initMaps() {
  var maybeMaps = document.querySelectorAll(".path-node-707 section.deck-one-column");
  if (maybeMaps.length) {
    maybeMaps[0].style.display = 'block';
    for (var i = 1; i < maybeMaps.length; i++) {
      if (maybeMaps[i].querySelectorAll('.venue-map').length) {
        maybeMaps[i].style.display = 'none';
      }
    }
  }
}

function updateMaps() {
  var maybeMaps = document.querySelectorAll(".path-node-707 section.deck-one-column");
  if (maybeMaps.length) {
    // Filter to our actual maps.
    var maps = [];
    for (var i = 0; i < maybeMaps.length; i++) {
      if (maybeMaps[i].querySelectorAll('.venue-map').length) {
        maps.push(maybeMaps[i]);
      }
    }
    // Swap maps to the next one available, cycle around.
    for (var i = 0; i < maps.length; i++) {
      if (maps[i].style.display == 'block') {
        maps[i].style.display = 'none';
        if (i < (maps.length - 1)) {
          maps[i+1].style.display = 'block';
        }
        else {
          maps[0].style.display = 'block';
        }
        break;
      }
    }
  }
}

window.onload = function() { updateProgram(); initNews(); initMaps(); }

// Allow opting out of the changing page for CSS development.
if (window.location.search != '?cssdebug') {
  // Update schedule every 5 seconds.
  setInterval(updateProgram, 1000*5);

  // Update news every 10 seconds.
  setInterval(updateNews, 1000*10);

  // Update maps every 10 seconds.
  setInterval(updateMaps, 1000*10);

  // Reload page every 3 minutes to make sure we have most up to date data in case of changes.
  function refreshPage() {
    location.reload();
  }
  setTimeout(refreshPage, 1000*60*3); // Every 3 mins refresh page
  //setTimeout(refreshPage, 1000*30); // Every 30sec for testing
}

(() => {
  const width = screen.width;
  const height = screen.height;

  let node = document.createElement('div');
  let textNode = document.createTextNode(width + "x" + height);
  node.appendChild(textNode);
  node.classList.add('infoscreen-debug');
  // document.body.appendChild(node);
})();

(() => {
  let Masonry = require('masonry-layout');

  let container = document.querySelectorAll('.path-infoscreen-social-wall .view-social-wall .view-content');


  // Load the twitter widgets script
  window.twttr = (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0],
      t = window.twttr || {};
    if (d.getElementById(id)) return t;
    js = d.createElement(s);
    js.id = id;
    js.src = "https://platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore(js, fjs);

    t._e = [];
    t.ready = function(f) {
      t._e.push(f);
    };

    return t;
  }(document, "script", "twitter-wjs"));

  // Bind an event to rerun the masonry layout when a tweet is rendered
  let gridMasonry = null;
  twttr.ready(
    function (twttr) {
      twttr.events.bind(
        'rendered',
        function (event) {
          if (gridMasonry === null) {
            gridMasonry = new Masonry('.grid', {
                itemSelector: '.grid-item',
                columnWidth: '.grid-item'
              }
            );
          }
          else {
            gridMasonry.layout();
          }
        }
      );
    }
  );


})();

