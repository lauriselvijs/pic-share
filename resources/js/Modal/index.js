import Modal from "./Modal";
import ModalView from "./ModalView";
import ModalController from "./ModalController";

// TODO:
// [ ] - Move to ts
const modal = new Modal();
const modalView = new ModalView(modal);
const modalController = new ModalController(modal, modalView);

modalController.renderView();
