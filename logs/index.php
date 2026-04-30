<script>
function initFreshdesk() {
  window.fdWidget.init({
    token: "01KQ9STRC0VM1XQRP7YXDJ6K6Z",
    host: "https://abiodunemmanuel781.freshdesk.com",
    widgetId: "01KQ9STV0HHNWHC0GJV4WQ0K0Y"
  });
}

function initialize(i,t){var e;i.getElementById(t)?initFreshdesk():((e=i.createElement("script")).id=t,e.async=!0,e.src="https://abiodunemmanuel781.freshdesk.com/webchat/js/widget.js",e.onload=initFreshdesk,i.head.appendChild(e))}function initiateCall(){initialize(document,"Freshdesk-js-sdk")}window.addEventListener?window.addEventListener("load",initiateCall,!1):window.attachEvent("load",initiateCall,!1);
</script>