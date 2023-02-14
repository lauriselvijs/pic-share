import Modal from "./Modal";
import ModalView from "./ModalView";
import ModalController from "./ModalController";

// TODO:
// [ ] - Add to typescript
const modal = new Modal();
const modalView = new ModalView(modal);
const modalController = new ModalController(modal, modalView);

modalController.renderView();
