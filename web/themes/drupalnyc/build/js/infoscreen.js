!function(t){var e={};function i(n){if(e[n])return e[n].exports;var o=e[n]={i:n,l:!1,exports:{}};return t[n].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=e,i.d=function(t,e,n){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:n})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(i.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)i.d(n,o,function(e){return t[e]}.bind(null,o));return n},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="/themes/drupalnyc/build/",i(i.s="fs5F")}({CUlp:function(t,e,i){var n,o;"undefined"!=typeof window&&window,void 0===(o="function"==typeof(n=function(){"use strict";function t(){}var e=t.prototype;return e.on=function(t,e){if(t&&e){var i=this._events=this._events||{},n=i[t]=i[t]||[];return-1==n.indexOf(e)&&n.push(e),this}},e.once=function(t,e){if(t&&e){this.on(t,e);var i=this._onceEvents=this._onceEvents||{};return(i[t]=i[t]||{})[e]=!0,this}},e.off=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var n=i.indexOf(e);return-1!=n&&i.splice(n,1),this}},e.emitEvent=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){i=i.slice(0),e=e||[];for(var n=this._onceEvents&&this._onceEvents[t],o=0;o<i.length;o++){var r=i[o];n&&n[r]&&(this.off(t,r),delete n[r]),r.apply(this,e)}return this}},e.allOff=function(){delete this._events,delete this._onceEvents},t})?n.call(e,i,e,t):n)||(t.exports=o)},Hy43:function(t,e,i){var n,o;
/*!
 * Outlayer v2.1.1
 * the brains and guts of a layout library
 * MIT license
 */!function(r,s){"use strict";n=[i("CUlp"),i("QK1G"),i("YVj6"),i("KK1e")],void 0===(o=function(t,e,i,n){return function(t,e,i,n,o){var r=t.console,s=t.jQuery,a=function(){},h=0,u={};function l(t,e){var i=n.getQueryElement(t);if(i){this.element=i,s&&(this.$element=s(this.element)),this.options=n.extend({},this.constructor.defaults),this.option(e);var o=++h;this.element.outlayerGUID=o,u[o]=this,this._create(),this._getOption("initLayout")&&this.layout()}else r&&r.error("Bad element for "+this.constructor.namespace+": "+(i||t))}l.namespace="outlayer",l.Item=o,l.defaults={containerStyle:{position:"relative"},initLayout:!0,originLeft:!0,originTop:!0,resize:!0,resizeContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}};var c=l.prototype;function d(t){function e(){t.apply(this,arguments)}return e.prototype=Object.create(t.prototype),e.prototype.constructor=e,e}n.extend(c,e.prototype),c.option=function(t){n.extend(this.options,t)},c._getOption=function(t){var e=this.constructor.compatOptions[t];return e&&void 0!==this.options[e]?this.options[e]:this.options[t]},l.compatOptions={initLayout:"isInitLayout",horizontal:"isHorizontal",layoutInstant:"isLayoutInstant",originLeft:"isOriginLeft",originTop:"isOriginTop",resize:"isResizeBound",resizeContainer:"isResizingContainer"},c._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),n.extend(this.element.style,this.options.containerStyle),this._getOption("resize")&&this.bindResize()},c.reloadItems=function(){this.items=this._itemize(this.element.children)},c._itemize=function(t){for(var e=this._filterFindItemElements(t),i=this.constructor.Item,n=[],o=0;o<e.length;o++){var r=new i(e[o],this);n.push(r)}return n},c._filterFindItemElements=function(t){return n.filterFindElements(t,this.options.itemSelector)},c.getItemElements=function(){return this.items.map((function(t){return t.element}))},c.layout=function(){this._resetLayout(),this._manageStamps();var t=this._getOption("layoutInstant"),e=void 0!==t?t:!this._isLayoutInited;this.layoutItems(this.items,e),this._isLayoutInited=!0},c._init=c.layout,c._resetLayout=function(){this.getSize()},c.getSize=function(){this.size=i(this.element)},c._getMeasurement=function(t,e){var n,o=this.options[t];o?("string"==typeof o?n=this.element.querySelector(o):o instanceof HTMLElement&&(n=o),this[t]=n?i(n)[e]:o):this[t]=0},c.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},c._getItemsForLayout=function(t){return t.filter((function(t){return!t.isIgnored}))},c._layoutItems=function(t,e){if(this._emitCompleteOnItems("layout",t),t&&t.length){var i=[];t.forEach((function(t){var n=this._getItemLayoutPosition(t);n.item=t,n.isInstant=e||t.isLayoutInstant,i.push(n)}),this),this._processLayoutQueue(i)}},c._getItemLayoutPosition=function(){return{x:0,y:0}},c._processLayoutQueue=function(t){this.updateStagger(),t.forEach((function(t,e){this._positionItem(t.item,t.x,t.y,t.isInstant,e)}),this)},c.updateStagger=function(){var t=this.options.stagger;if(null!=t)return this.stagger=function(t){if("number"==typeof t)return t;var e=t.match(/(^\d*\.?\d*)(\w*)/),i=e&&e[1],n=e&&e[2];if(!i.length)return 0;return(i=parseFloat(i))*(f[n]||1)}(t),this.stagger;this.stagger=0},c._positionItem=function(t,e,i,n,o){n?t.goTo(e,i):(t.stagger(o*this.stagger),t.moveTo(e,i))},c._postLayout=function(){this.resizeContainer()},c.resizeContainer=function(){if(this._getOption("resizeContainer")){var t=this._getContainerSize();t&&(this._setContainerMeasure(t.width,!0),this._setContainerMeasure(t.height,!1))}},c._getContainerSize=a,c._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},c._emitCompleteOnItems=function(t,e){var i=this;function n(){i.dispatchEvent(t+"Complete",null,[e])}var o=e.length;if(e&&o){var r=0;e.forEach((function(e){e.once(t,s)}))}else n();function s(){++r==o&&n()}},c.dispatchEvent=function(t,e,i){var n=e?[e].concat(i):i;if(this.emitEvent(t,n),s)if(this.$element=this.$element||s(this.element),e){var o=s.Event(e);o.type=t,this.$element.trigger(o,i)}else this.$element.trigger(t,i)},c.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},c.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},c.stamp=function(t){(t=this._find(t))&&(this.stamps=this.stamps.concat(t),t.forEach(this.ignore,this))},c.unstamp=function(t){(t=this._find(t))&&t.forEach((function(t){n.removeFrom(this.stamps,t),this.unignore(t)}),this)},c._find=function(t){if(t)return"string"==typeof t&&(t=this.element.querySelectorAll(t)),t=n.makeArray(t)},c._manageStamps=function(){this.stamps&&this.stamps.length&&(this._getBoundingRect(),this.stamps.forEach(this._manageStamp,this))},c._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},c._manageStamp=a,c._getElementOffset=function(t){var e=t.getBoundingClientRect(),n=this._boundingRect,o=i(t);return{left:e.left-n.left-o.marginLeft,top:e.top-n.top-o.marginTop,right:n.right-e.right-o.marginRight,bottom:n.bottom-e.bottom-o.marginBottom}},c.handleEvent=n.handleEvent,c.bindResize=function(){t.addEventListener("resize",this),this.isResizeBound=!0},c.unbindResize=function(){t.removeEventListener("resize",this),this.isResizeBound=!1},c.onresize=function(){this.resize()},n.debounceMethod(l,"onresize",100),c.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},c.needsResizeLayout=function(){var t=i(this.element);return this.size&&t&&t.innerWidth!==this.size.innerWidth},c.addItems=function(t){var e=this._itemize(t);return e.length&&(this.items=this.items.concat(e)),e},c.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},c.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},c.reveal=function(t){if(this._emitCompleteOnItems("reveal",t),t&&t.length){var e=this.updateStagger();t.forEach((function(t,i){t.stagger(i*e),t.reveal()}))}},c.hide=function(t){if(this._emitCompleteOnItems("hide",t),t&&t.length){var e=this.updateStagger();t.forEach((function(t,i){t.stagger(i*e),t.hide()}))}},c.revealItemElements=function(t){var e=this.getItems(t);this.reveal(e)},c.hideItemElements=function(t){var e=this.getItems(t);this.hide(e)},c.getItem=function(t){for(var e=0;e<this.items.length;e++){var i=this.items[e];if(i.element==t)return i}},c.getItems=function(t){t=n.makeArray(t);var e=[];return t.forEach((function(t){var i=this.getItem(t);i&&e.push(i)}),this),e},c.remove=function(t){var e=this.getItems(t);this._emitCompleteOnItems("remove",e),e&&e.length&&e.forEach((function(t){t.remove(),n.removeFrom(this.items,t)}),this)},c.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="",this.items.forEach((function(t){t.destroy()})),this.unbindResize();var e=this.element.outlayerGUID;delete u[e],delete this.element.outlayerGUID,s&&s.removeData(this.element,this.constructor.namespace)},l.data=function(t){var e=(t=n.getQueryElement(t))&&t.outlayerGUID;return e&&u[e]},l.create=function(t,e){var i=d(l);return i.defaults=n.extend({},l.defaults),n.extend(i.defaults,e),i.compatOptions=n.extend({},l.compatOptions),i.namespace=t,i.data=l.data,i.Item=d(o),n.htmlInit(i,t),s&&s.bridget&&s.bridget(t,i),i};var f={ms:1,s:1e3};return l.Item=o,l}(r,t,e,i,n)}.apply(e,n))||(t.exports=o)}(window)},KK1e:function(t,e,i){var n,o,r;window,o=[i("CUlp"),i("QK1G")],void 0===(r="function"==typeof(n=function(t,e){"use strict";var i=document.documentElement.style,n="string"==typeof i.transition?"transition":"WebkitTransition",o="string"==typeof i.transform?"transform":"WebkitTransform",r={WebkitTransition:"webkitTransitionEnd",transition:"transitionend"}[n],s={transform:o,transition:n,transitionDuration:n+"Duration",transitionProperty:n+"Property",transitionDelay:n+"Delay"};function a(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}var h=a.prototype=Object.create(t.prototype);h.constructor=a,h._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},h.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},h.getSize=function(){this.size=e(this.element)},h.css=function(t){var e=this.element.style;for(var i in t)e[s[i]||i]=t[i]},h.getPosition=function(){var t=getComputedStyle(this.element),e=this.layout._getOption("originLeft"),i=this.layout._getOption("originTop"),n=t[e?"left":"right"],o=t[i?"top":"bottom"],r=parseFloat(n),s=parseFloat(o),a=this.layout.size;-1!=n.indexOf("%")&&(r=r/100*a.width),-1!=o.indexOf("%")&&(s=s/100*a.height),r=isNaN(r)?0:r,s=isNaN(s)?0:s,r-=e?a.paddingLeft:a.paddingRight,s-=i?a.paddingTop:a.paddingBottom,this.position.x=r,this.position.y=s},h.layoutPosition=function(){var t=this.layout.size,e={},i=this.layout._getOption("originLeft"),n=this.layout._getOption("originTop"),o=i?"paddingLeft":"paddingRight",r=i?"left":"right",s=i?"right":"left",a=this.position.x+t[o];e[r]=this.getXValue(a),e[s]="";var h=n?"paddingTop":"paddingBottom",u=n?"top":"bottom",l=n?"bottom":"top",c=this.position.y+t[h];e[u]=this.getYValue(c),e[l]="",this.css(e),this.emitEvent("layout",[this])},h.getXValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&!e?t/this.layout.size.width*100+"%":t+"px"},h.getYValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&e?t/this.layout.size.height*100+"%":t+"px"},h._transitionTo=function(t,e){this.getPosition();var i=this.position.x,n=this.position.y,o=t==this.position.x&&e==this.position.y;if(this.setPosition(t,e),!o||this.isTransitioning){var r=t-i,s=e-n,a={};a.transform=this.getTranslate(r,s),this.transition({to:a,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})}else this.layoutPosition()},h.getTranslate=function(t,e){return"translate3d("+(t=this.layout._getOption("originLeft")?t:-t)+"px, "+(e=this.layout._getOption("originTop")?e:-e)+"px, 0)"},h.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},h.moveTo=h._transitionTo,h.setPosition=function(t,e){this.position.x=parseFloat(t),this.position.y=parseFloat(e)},h._nonTransition=function(t){for(var e in this.css(t.to),t.isCleaning&&this._removeStyles(t.to),t.onTransitionEnd)t.onTransitionEnd[e].call(this)},h.transition=function(t){if(parseFloat(this.layout.options.transitionDuration)){var e=this._transn;for(var i in t.onTransitionEnd)e.onEnd[i]=t.onTransitionEnd[i];for(i in t.to)e.ingProperties[i]=!0,t.isCleaning&&(e.clean[i]=!0);t.from&&(this.css(t.from),this.element.offsetHeight),this.enableTransition(t.to),this.css(t.to),this.isTransitioning=!0}else this._nonTransition(t)};var u="opacity,"+o.replace(/([A-Z])/g,(function(t){return"-"+t.toLowerCase()}));h.enableTransition=function(){if(!this.isTransitioning){var t=this.layout.options.transitionDuration;t="number"==typeof t?t+"ms":t,this.css({transitionProperty:u,transitionDuration:t,transitionDelay:this.staggerDelay||0}),this.element.addEventListener(r,this,!1)}},h.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},h.onotransitionend=function(t){this.ontransitionend(t)};var l={"-webkit-transform":"transform"};h.ontransitionend=function(t){if(t.target===this.element){var e=this._transn,i=l[t.propertyName]||t.propertyName;delete e.ingProperties[i],function(t){for(var e in t)return!1;return!0}(e.ingProperties)&&this.disableTransition(),i in e.clean&&(this.element.style[t.propertyName]="",delete e.clean[i]),i in e.onEnd&&(e.onEnd[i].call(this),delete e.onEnd[i]),this.emitEvent("transitionEnd",[this])}},h.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(r,this,!1),this.isTransitioning=!1},h._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var c={transitionProperty:"",transitionDuration:"",transitionDelay:""};return h.removeTransitionStyles=function(){this.css(c)},h.stagger=function(t){t=isNaN(t)?0:t,this.staggerDelay=t+"ms"},h.removeElem=function(){this.element.parentNode.removeChild(this.element),this.css({display:""}),this.emitEvent("remove",[this])},h.remove=function(){n&&parseFloat(this.layout.options.transitionDuration)?(this.once("transitionEnd",(function(){this.removeElem()})),this.hide()):this.removeElem()},h.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options,e={};e[this.getHideRevealTransitionEndProperty("visibleStyle")]=this.onRevealTransitionEnd,this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0,onTransitionEnd:e})},h.onRevealTransitionEnd=function(){this.isHidden||this.emitEvent("reveal")},h.getHideRevealTransitionEndProperty=function(t){var e=this.layout.options[t];if(e.opacity)return"opacity";for(var i in e)return i},h.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options,e={};e[this.getHideRevealTransitionEndProperty("hiddenStyle")]=this.onHideTransitionEnd,this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:e})},h.onHideTransitionEnd=function(){this.isHidden&&(this.css({display:"none"}),this.emitEvent("hide"))},h.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},a})?n.apply(e,o):n)||(t.exports=r)},QK1G:function(t,e,i){var n,o;
/*!
 * getSize v2.0.3
 * measure size of elements
 * MIT license
 */window,void 0===(o="function"==typeof(n=function(){"use strict";function t(t){var e=parseFloat(t);return-1==t.indexOf("%")&&!isNaN(e)&&e}var e="undefined"==typeof console?function(){}:function(t){console.error(t)},i=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"],n=i.length;function o(t){var i=getComputedStyle(t);return i||e("Style returned "+i+". Are you running this code in a hidden iframe on Firefox? See https://bit.ly/getsizebug1"),i}var r,s=!1;function a(e){if(function(){if(!s){s=!0;var e=document.createElement("div");e.style.width="200px",e.style.padding="1px 2px 3px 4px",e.style.borderStyle="solid",e.style.borderWidth="1px 2px 3px 4px",e.style.boxSizing="border-box";var i=document.body||document.documentElement;i.appendChild(e);var n=o(e);r=200==Math.round(t(n.width)),a.isBoxSizeOuter=r,i.removeChild(e)}}(),"string"==typeof e&&(e=document.querySelector(e)),e&&"object"==typeof e&&e.nodeType){var h=o(e);if("none"==h.display)return function(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0;e<n;e++)t[i[e]]=0;return t}();var u={};u.width=e.offsetWidth,u.height=e.offsetHeight;for(var l=u.isBorderBox="border-box"==h.boxSizing,c=0;c<n;c++){var d=i[c],f=h[d],m=parseFloat(f);u[d]=isNaN(m)?0:m}var p=u.paddingLeft+u.paddingRight,g=u.paddingTop+u.paddingBottom,v=u.marginLeft+u.marginRight,y=u.marginTop+u.marginBottom,_=u.borderLeftWidth+u.borderRightWidth,b=u.borderTopWidth+u.borderBottomWidth,w=l&&r,E=t(h.width);!1!==E&&(u.width=E+(w?0:p+_));var S=t(h.height);return!1!==S&&(u.height=S+(w?0:g+b)),u.innerWidth=u.width-(p+_),u.innerHeight=u.height-(g+b),u.outerWidth=u.width+v,u.outerHeight=u.height+y,u}}return a})?n.call(e,i,e,t):n)||(t.exports=o)},YVj6:function(t,e,i){var n,o;!function(r,s){n=[i("x0Ue")],void 0===(o=function(t){return function(t,e){"use strict";var i={extend:function(t,e){for(var i in e)t[i]=e[i];return t},modulo:function(t,e){return(t%e+e)%e}},n=Array.prototype.slice;i.makeArray=function(t){return Array.isArray(t)?t:null==t?[]:"object"==typeof t&&"number"==typeof t.length?n.call(t):[t]},i.removeFrom=function(t,e){var i=t.indexOf(e);-1!=i&&t.splice(i,1)},i.getParent=function(t,i){for(;t.parentNode&&t!=document.body;)if(t=t.parentNode,e(t,i))return t},i.getQueryElement=function(t){return"string"==typeof t?document.querySelector(t):t},i.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},i.filterFindElements=function(t,n){t=i.makeArray(t);var o=[];return t.forEach((function(t){if(t instanceof HTMLElement)if(n){e(t,n)&&o.push(t);for(var i=t.querySelectorAll(n),r=0;r<i.length;r++)o.push(i[r])}else o.push(t)})),o},i.debounceMethod=function(t,e,i){i=i||100;var n=t.prototype[e],o=e+"Timeout";t.prototype[e]=function(){var t=this[o];clearTimeout(t);var e=arguments,r=this;this[o]=setTimeout((function(){n.apply(r,e),delete r[o]}),i)}},i.docReady=function(t){var e=document.readyState;"complete"==e||"interactive"==e?setTimeout(t):document.addEventListener("DOMContentLoaded",t)},i.toDashed=function(t){return t.replace(/(.)([A-Z])/g,(function(t,e,i){return e+"-"+i})).toLowerCase()};var o=t.console;return i.htmlInit=function(e,n){i.docReady((function(){var r=i.toDashed(n),s="data-"+r,a=document.querySelectorAll("["+s+"]"),h=document.querySelectorAll(".js-"+r),u=i.makeArray(a).concat(i.makeArray(h)),l=s+"-options",c=t.jQuery;u.forEach((function(t){var i,r=t.getAttribute(s)||t.getAttribute(l);try{i=r&&JSON.parse(r)}catch(e){return void(o&&o.error("Error parsing "+s+" on "+t.className+": "+e))}var a=new e(t,i);c&&c.data(t,n,a)}))}))},i}(r,t)}.apply(e,n))||(t.exports=o)}(window)},fs5F:function(t,e,i){function n(){var t=document.querySelectorAll(".view-id-room .views-row");if(0!=t.length){for(var e=0;e<t.length;e++){new Date(t[e].querySelector(".views-field-field-ends-at time").getAttribute("datetime").replace("Z",""))<new Date&&document.querySelector(".view-id-room .view-content").removeChild(t[e])}var i=document.querySelector(".view-id-room .views-row"),n=new Date(i.querySelector(".views-field-field-start time").getAttribute("datetime").replace("Z","")),o=i.querySelector(".views-row-first-header");null==o&&((o=document.createElement("div")).className="views-row-first-header",i.insertBefore(o,i.querySelector(".views-field-title")));var r=new Date;if(n>r){var s=Math.floor((n-r)/1e3);o.innerHTML=s<120?"Starts about now":s<7200?"In "+Math.floor(s/60)+" minutes":s<172800?"In "+Math.floor(s/3600)+" hours":"In "+Math.floor(s/86400)+" days"}else{var a=Math.floor((r-n)/1e3);o.innerHTML=a<120?"Started just now":a<7200?"Started "+Math.floor(a/60)+" minutes ago":"Started "+Math.floor(a/3600)+" hours ago"}}}if(window.onload=function(){n(),function(){var t=document.querySelectorAll(".view-infoscreen-announcements .views-row");if(!(t.length<2)){var e=document.querySelector(".view-infoscreen-announcements"),i=document.createElement("div");i.className="newsdots",t[0].style.display="block",i.innerHTML="&bull; ";for(var n=1;n<t.length;n++)i.innerHTML+="&bull; ",t[n].style.display="none";e.insertBefore(i,e.querySelector(".views-content"))}}(),function(){var t=document.querySelectorAll(".path-node-707 section.deck-one-column");if(t.length){t[0].style.display="block";for(var e=1;e<t.length;e++)t[e].querySelectorAll(".venue-map").length&&(t[e].style.display="none")}}()},"?cssdebug"!=window.location.search){setInterval(n,5e3),setInterval((function(){var t=document.querySelectorAll(".view-infoscreen-announcements .views-row");if(!(t.length<2))for(var e=0;e<t.length;e++)if("block"==t[e].style.display){t[e].style.display="none",e<t.length-1?t[e+1].style.display="block":t[0].style.display="block";break}}),1e4),setInterval((function(){var t=document.querySelectorAll(".path-node-707 section.deck-one-column");if(t.length){for(var e=[],i=0;i<t.length;i++)t[i].querySelectorAll(".venue-map").length&&e.push(t[i]);for(i=0;i<e.length;i++)if("block"==e[i].style.display){e[i].style.display="none",i<e.length-1?e[i+1].style.display="block":e[0].style.display="block";break}}}),1e4),setTimeout((function(){location.reload()}),18e4)}var o,r,s,a;o=screen.width,r=screen.height,s=document.createElement("div"),a=document.createTextNode(o+"x"+r),s.appendChild(a),s.classList.add("infoscreen-debug"),function(){var t,e,n,o,r,s,a=i("hNNL");document.querySelectorAll(".path-infoscreen-social-wall .view-social-wall .view-content");window.twttr=(t=document,e="script",n="twitter-wjs",r=t.getElementsByTagName(e)[0],s=window.twttr||{},t.getElementById(n)||((o=t.createElement(e)).id=n,o.src="https://platform.twitter.com/widgets.js",r.parentNode.insertBefore(o,r),s._e=[],s.ready=function(t){s._e.push(t)}),s);var h=null;twttr.ready((function(t){t.events.bind("rendered",(function(t){null===h?h=new a(".grid",{itemSelector:".grid-item",columnWidth:".grid-item"}):h.layout()}))}))}()},hNNL:function(t,e,i){var n,o,r;
/*!
 * Masonry v4.2.2
 * Cascading grid layout library
 * https://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */window,o=[i("Hy43"),i("QK1G")],void 0===(r="function"==typeof(n=function(t,e){"use strict";var i=t.create("masonry");i.compatOptions.fitWidth="isFitWidth";var n=i.prototype;return n._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns(),this.colYs=[];for(var t=0;t<this.cols;t++)this.colYs.push(0);this.maxY=0,this.horizontalColIndex=0},n.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],i=t&&t.element;this.columnWidth=i&&e(i).outerWidth||this.containerWidth}var n=this.columnWidth+=this.gutter,o=this.containerWidth+this.gutter,r=o/n,s=n-o%n;r=Math[s&&s<1?"round":"floor"](r),this.cols=Math.max(r,1)},n.getContainerWidth=function(){var t=this._getOption("fitWidth")?this.element.parentNode:this.element,i=e(t);this.containerWidth=i&&i.innerWidth},n._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth%this.columnWidth,i=Math[e&&e<1?"round":"ceil"](t.size.outerWidth/this.columnWidth);i=Math.min(i,this.cols);for(var n=this[this.options.horizontalOrder?"_getHorizontalColPosition":"_getTopColPosition"](i,t),o={x:this.columnWidth*n.col,y:n.y},r=n.y+t.size.outerHeight,s=i+n.col,a=n.col;a<s;a++)this.colYs[a]=r;return o},n._getTopColPosition=function(t){var e=this._getTopColGroup(t),i=Math.min.apply(Math,e);return{col:e.indexOf(i),y:i}},n._getTopColGroup=function(t){if(t<2)return this.colYs;for(var e=[],i=this.cols+1-t,n=0;n<i;n++)e[n]=this._getColGroupY(n,t);return e},n._getColGroupY=function(t,e){if(e<2)return this.colYs[t];var i=this.colYs.slice(t,t+e);return Math.max.apply(Math,i)},n._getHorizontalColPosition=function(t,e){var i=this.horizontalColIndex%this.cols;i=t>1&&i+t>this.cols?0:i;var n=e.size.outerWidth&&e.size.outerHeight;return this.horizontalColIndex=n?i+t:this.horizontalColIndex,{col:i,y:this._getColGroupY(i,t)}},n._manageStamp=function(t){var i=e(t),n=this._getElementOffset(t),o=this._getOption("originLeft")?n.left:n.right,r=o+i.outerWidth,s=Math.floor(o/this.columnWidth);s=Math.max(0,s);var a=Math.floor(r/this.columnWidth);a-=r%this.columnWidth?0:1,a=Math.min(this.cols-1,a);for(var h=(this._getOption("originTop")?n.top:n.bottom)+i.outerHeight,u=s;u<=a;u++)this.colYs[u]=Math.max(h,this.colYs[u])},n._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this._getOption("fitWidth")&&(t.width=this._getContainerFitWidth()),t},n._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},n.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!=this.containerWidth},i})?n.apply(e,o):n)||(t.exports=r)},x0Ue:function(t,e,i){var n,o;!function(r,s){"use strict";void 0===(o="function"==typeof(n=s)?n.call(e,i,e,t):n)||(t.exports=o)}(window,(function(){"use strict";var t=function(){var t=window.Element.prototype;if(t.matches)return"matches";if(t.matchesSelector)return"matchesSelector";for(var e=["webkit","moz","ms","o"],i=0;i<e.length;i++){var n=e[i]+"MatchesSelector";if(t[n])return n}}();return function(e,i){return e[t](i)}}))}});