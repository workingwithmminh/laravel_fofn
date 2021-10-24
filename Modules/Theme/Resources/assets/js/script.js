$(document).ready(function() {
    $(".sidebar .dropdown-btn").click(function() {
        $(".dropdown-btn")
            .not($(this))
            .parent(".nav-item")
            .children(".dropdown-container")
            .slideUp("200");
        $(this)
            .parent(".nav-item")
            .children(".dropdown-container")
            .slideToggle("200");
        $(this)
            .find(".dropdown-icon")
            .toggleClass("active");
    });

    $(".sidebarBtn").click(function() {
        $(".sidebar").toggleClass("active");
        $(this).removeClass("d-block");
        $(this).addClass("d-none");
        $(".sidebar").css("box-shadow", "0 0 10px rgba(255, 255, 255, 0.9)");
        $("#overlay").show();
    });

    $(".sidebar .sidebarBtn-close").click(function() {
        $(".sidebar").toggleClass("active");
        $(".sidebarBtn").removeClass("d-none");
        $(".sidebarBtn").addClass("d-block");
        $("#overlay").hide();
        $(".sidebar").css("box-shadow", "none");
    });

    $("#overlay").click(function(e) {
        if ($(".sidebar").hasClass("active")) {
            $(".sidebar").removeClass("active");
            $(".sidebarBtn").addClass("d-block");
        }
        $(".dropdown-container").hide();
        $("#overlay").hide();
        $(".sidebar").css("box-shadow", "none");
    });

    function showButton() {
        var button = $(".backtop"),
            view = $(window),
            timeoutKey = -1;

        $(document).on("scroll", function() {
            if (timeoutKey) {
                window.clearTimeout(timeoutKey);
            }
            timeoutKey = window.setTimeout(function() {
                if (view.scrollTop() < 100) {
                    button.fadeOut();
                } else {
                    button.fadeIn();
                }
            }, 100);
        });
    }

    $(".backtop").on("click", function() {
        $("html, body")
            .stop()
            .animate(
                {
                    scrollTop: 0,
                },
                500,
                "linear"
            );
        return false;
    });

    $(function() {
        showButton();
    });
});
