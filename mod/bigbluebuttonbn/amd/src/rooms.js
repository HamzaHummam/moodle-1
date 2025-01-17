// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * JS actions for the rooms page for mod_bigbluebuttonbn.
 *
 * @module      mod_bigbluebuttonbn/rooms
 * @copyright   2021 Blindside Networks Inc
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import './actions';
import * as repository from './repository';
import * as roomUpdater from './roomupdater';
import {
    exception as displayException,
    fetchNotifications,
} from 'core/notification';

import {eventTypes, notifyCurrentSessionEnded} from './events';

<<<<<<< HEAD
const timeoutjoin = 5000;

export const init = (bigbluebuttonbnid) => {
=======
/**
 * Init the room
 *
 * @param {Number} bigbluebuttonbnid bigblubeutton identifier
 * @param {Number} pollInterval poll interval in miliseconds
 */
export const init = (bigbluebuttonbnid, pollInterval) => {
>>>>>>> master
    const completionElement = document.querySelector('a[href*=completion_validate]');
    if (completionElement) {
        completionElement.addEventListener("click", () => {
            repository.completionValidate(bigbluebuttonbnid).catch(displayException);
        });
    }

    document.addEventListener('click', e => {
        const joinButton = e.target.closest('[data-action="join"]');
        if (joinButton) {
            window.open(joinButton.href, 'bigbluebutton_conference');
            e.preventDefault();
<<<<<<< HEAD
            // Gives the user a bit of time to go into the meeting.
            setTimeout(() => {
                roomUpdater.updateRoom(true);
                }, timeoutjoin);
=======
            // Gives the user a bit of time to go into the meeting before polling the room.
            setTimeout(() => {
                roomUpdater.updateRoom(true);
            }, pollInterval);
>>>>>>> master
        }
    });

    document.addEventListener(eventTypes.sessionEnded, () => {
        roomUpdater.stop();
        roomUpdater.updateRoom();
        fetchNotifications();
    });

    window.addEventListener(eventTypes.currentSessionEnded, () => {
        roomUpdater.stop();
        roomUpdater.updateRoom();
        fetchNotifications();
    });
    // Room update.
<<<<<<< HEAD
    roomUpdater.start();
};

/**
 * Handle autoclosing of the window.
 */
const autoclose = () => {
    window.opener.setTimeout(() => {
        roomUpdater.updateRoom(true);
    }, timeoutjoin);
    window.removeEventListener('onbeforeunload', autoclose);
=======
    roomUpdater.start(pollInterval);
>>>>>>> master
};

/**
 * Auto close child windows when clicking the End meeting button.
 * @param {Number} closeDelay time to wait in miliseconds before closing the window
 */
export const setupWindowAutoClose = (closeDelay = 2000) => {
    notifyCurrentSessionEnded(window.opener);
    window.addEventListener('onbeforeunload', () => {
            window.opener.setTimeout(() => {
                roomUpdater.updateRoom(true);
            }, closeDelay);
        },
        {
            once: true
        });
    window.close(); // This does not work as scripts can only close windows that are opened by themselves.
};
