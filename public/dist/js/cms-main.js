function cmsTimeAgo(t) {
    t = t || "abbr.timeago",
    $(t).timeago()
}

$(document).ready(function() {
    $(".carousel").carousel({
        interval: 2500
    })
}),
$(document).ready(function() {
	$("[data-method]").not(".disabled").append(function() {
        var t = "\n";
        return t += "<form action='" + $(this).attr("href") + "' method='POST' style='display:none'>\n",
        t += " <input type='hidden' name='_method' value='" + $(this).attr("data-method") + "'>\n",
        $(this).attr("data-token") && (t += "<input type='hidden' name='_token' value='" + $(this).attr("data-token") + "'>\n"),
        t += "</form>\n"
    }).removeAttr("href").attr("onclick", ' if ($(this).hasClass(\'action_confirm\')) { if(confirm("Are you sure you want to do this?")) { $(this).find("form").submit(); } } else { $(this).find("form").submit(); }')
}),
$(document).ready(function() {
    setTimeout(function() {
        alerts = $(".cms-alert"),
        alerts.addClass("bounceOut"),
        alerts.addClass("animated"),
        setTimeout(function() {
            alerts.slideUp(500,
            function() {
                alerts.remove()
            })
        },
        500)
    },
    2500)
});