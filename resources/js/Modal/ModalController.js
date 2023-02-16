import ModalService from "./ModalService";

class ModalController {
    #modal;
    #modalService;
    #view;

    constructor(modal, view) {
        this.#modal = modal;
        this.#view = view;
        this.#modalService = new ModalService(modal);

        this.#addEventListeners();
    }

    #addEventListeners() {
        this.#view.openModalMenuBtn?.addEventListener("click", () => {
            this.#modal.open();
            this.renderView();
        });
        this.#view.closeModalBtn?.addEventListener("click", () => {
            this.#modal.startCloseTransition();
            this.renderView();
        });
        this.#view.modalContent?.addEventListener("transitionend", () => {
            if (!this.#view.isModalContentExpanded) {
                this.#modal.endCloseTransition();
                this.#modal.close();
                this.renderView();
            }
        });
        window.addEventListener("resize", () => {
            this.#modalService.closeIfOnTablet();
            this.renderView();
        });
    }

    renderView() {
        this.#view.render();
    }
}

export default ModalController;
