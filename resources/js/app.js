import "./bootstrap";
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import jQuery from "jquery";

window.$ = jQuery;

window.Alpine = Alpine;
Alpine.plugin(persist);

Alpine.start();

// Dark mode
$("#dark-mode-btn").on("click", function () {
    $("#dark-mode-btn svg").toggle("fast");
});

// Open modal
$("#open-modal-menu-btn").on("click", function () {
    $("#modal-menu").show();
    $("#modal-content").animate({ width: "50%" }, "fast");
});

// Close modal
$("#close-modal-btn").on("click", function () {
    $("#modal-content").animate({ width: "0" }, "fast", function () {
        $("#modal-menu").hide();
    });
});
