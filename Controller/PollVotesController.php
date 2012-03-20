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
	public function add($id = null) {
		$this->PollVote->Poll->id = $id;
		if (!$this->PollVote->Poll->exists()) {
			throw new NotFoundException(__('Invalid poll'));
		}
		
		if ($this->request->is('post')) {
			try {			
				$this->PollVote->create();
				$this->PollVote->add($this->request->data);
				$this->Session->setFlash(__('The poll vote has been saved'));
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		if (CakeSession::read('Auth.User.id') != '') {
			$votes = $this->PollVote->find('count', array(
				'conditions' => array(
					'PollVote.user_id' => CakeSession::read('Auth.User.id'),
					'PollVote.poll_id' => $id,
					),
				));
		} else {
			$votes = null;
		}
		
		if (!empty($votes)) {
			$votes = $this->PollVote->PollOption->find('all', array(
				'conditions' => array(
					'PollOption.poll_id' => $id,
					),
				));
			$voteTotal = array_sum(Set::extract('/PollOption/vote_count', $votes));
			$this->set(compact('votes', 'voteTotal'));
		}
		
		$poll = $this->PollVote->Poll->find('first', array(
			'conditions' => array(
				'Poll.id' => $id,
				),
			));
		$pollOptions = $this->PollVote->PollOption->find('list', array(
			'conditions' => array(
				'PollOption.poll_id' => $id,
				),
			));
		$user = CakeSession::read('Auth.User.id');
		$this->set(compact('poll', 'user', 'pollOptions'));
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
