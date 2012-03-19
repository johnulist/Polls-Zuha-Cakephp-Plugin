<?php
App::uses('PollsAppController', 'Polls.Controller');
/**
 * PollVotes Controller
 *
 * @property PollVote $PollVote
 */
class PollVotesController extends PollsAppController {
	
/**
 * Name
 *
 * @var string
 */
	public $name = 'PollVotes';

/**
 * Uses model
 *
 * @var string
 */
	public $uses = 'Polls.PollVote';


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->PollVote->recursive = 0;
		$this->set('pollVotes', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->PollVote->id = $id;
		if (!$this->PollVote->exists()) {
			throw new NotFoundException(__('Invalid poll vote'));
		}
		$this->set('pollVote', $this->PollVote->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PollVote->create();
			if ($this->PollVote->save($this->request->data)) {
				$this->Session->setFlash(__('The poll vote has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The poll vote could not be saved. Please, try again.'));
			}
		}
		$polls = $this->PollVote->Poll->find('list');
		$pollOptions = $this->PollVote->PollOption->find('list');
		$users = $this->PollVote->User->find('list');
		$this->set(compact('polls', 'pollOptions', 'users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->PollVote->id = $id;
		if (!$this->PollVote->exists()) {
			throw new NotFoundException(__('Invalid poll vote'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PollVote->save($this->request->data)) {
				$this->Session->setFlash(__('The poll vote has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The poll vote could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->PollVote->read(null, $id);
		}
		$polls = $this->PollVote->Poll->find('list');
		$pollOptions = $this->PollVote->PollOption->find('list');
		$users = $this->PollVote->User->find('list');
		$this->set(compact('polls', 'pollOptions', 'users'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->PollVote->id = $id;
		if (!$this->PollVote->exists()) {
			throw new NotFoundException(__('Invalid poll vote'));
		}
		if ($this->PollVote->delete()) {
			$this->Session->setFlash(__('Poll vote deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Poll vote was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
