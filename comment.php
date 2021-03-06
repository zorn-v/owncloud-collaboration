<?php
/**
 * ownCloud - collaboration plugin
 *
 * @authors Dr.J.Akilandeswari, R.Ramki, R.Sasidharan, P.Suresh
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

\OCP\User::checkLoggedIn();
\OCP\App::checkAppEnabled('collaboration');

OCP\App::setActiveNavigationEntry( 'collaboration' );

OCP\Util::addScript('collaboration', 'comment');

OCP\Util::addStyle('collaboration', 'tabs');
OCP\Util::addStyle('collaboration', 'content_header');
OCP\Util::addStyle('collaboration', 'comment');

$tpl = new OCP\Template("collaboration", "comment", "user");

if(isset($_GET['post']))
{
	$details = OC_Collaboration_Post::getPostDetails($_GET['post']);

	if(count($details) == 0 || !OC_Collaboration_Post::isPostAccessibleToMember($_GET['post'], OC_User::getUser()))
	{
		goToDashboard();
	}
	else
	{
		$tpl->assign('details', $details);
		$tpl->assign('comments', OC_Collaboration_Comment::readComments($_GET['post']));
	}
}
else
{
	goToDashboard();
}

function goToDashboard()
{
	header('Location: ' . \OCP\Util::linkToRoute('collaboration_route', ['rel_path'=>'dashboard']));
	exit();
}

$tpl->printPage();
?>
