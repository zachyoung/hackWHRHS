$(document).ready(function(){
	//Position the content
	positionContent();
	//Smooth scroll links
	$(".nav-bar ul li a").click(function(){
		var name = $(this).attr("href").substring(1);
		$('html,body').animate({
			scrollTop: $("a[name="+name+"]").offset().top - $(".nav-bar").height() - 10
		}, 500);
	});
	$(window).scroll(positionContent);
	$(window).on("scroll resize", navBarFocus);
});

function positionContent(){
	$(".content").css({
		position: "absolute",
		top: $("div.home").height(),
		left: 0,
		display: "block",
		width: "100%"
	});
}

function navBarFocus(){
	$(".content > div").each(function(){
		var position = $(document).scrollTop() + $(".nav-bar").height();
		if (position >= $(this).offset().top && position <= $(this).offset().top + $(this).height()){
			$( "li." + $(this).attr("class") ).addClass("active");
		} else {
			$( "li." + $(this).attr("class") ).removeClass("active");
		}
	});
}