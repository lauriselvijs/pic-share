import ModalConfig from "./ModalConfig";

class ModalService {
    #modal;

    constructor(modal) {
        this.#modal = modal;
    }

    closeIfOnTablet() {
        if (
            document.body.offsetWidth > ModalConfig.TABLET_WIDTH &&
            this.#modal.isOpen
        ) {
            this.#modal.close();
        }
    }
}

export default ModalService;
