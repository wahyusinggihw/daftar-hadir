var hero = document.querySelector(".hero");
var hero_items = hero.querySelectorAll(".layers div");

window.addEventListener("scroll", function (e) {
  for (var i = 0; i < hero_items.length; i++) {
    var depth = hero_items[i].getAttribute("data-depth");

    (function (depth, item) {
      item.style.transform =
        "translateY(" + window.pageYOffset * (0.1 * depth) + "px)";
    })(depth, hero_items[i]);
  }
});