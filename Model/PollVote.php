<?php
App::uses('PollsAppModel', 'Polls.Model');
/**
 * PollVote Model
 *
 * @property Poll $Poll
 * @property PollOption $PollOption
 * @property User $User
 */
class PollVote extends PollsAppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Poll' => array(
			'className' => 'Polls.Poll',
			'foreignKey' => 'poll_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PollOption' => array(
			'className' => 'Polls.PollOption',
			'foreignKey' => 'poll_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
