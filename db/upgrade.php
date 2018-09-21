<?php
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
 * @author      Troy Williams
 * @package     Frankenstyle {@link https://docs.moodle.org/dev/Frankenstyle}
 * @copyright   2015 LearningWorks Ltd {@link http://www.learningworks.co.nz}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

function xmldb_enrol_arlo_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();

    // Moodle v3.5.0 release upgrade line.
    // Put any upgrade step following this.

    // Back out if using the old local and enrol plugin set.
    if ($oldversion < 2016052309) {
        echo $OUTPUT->notification(
            'Cannot upgrade from old enrol/local Arlo plugin set. You must be running single enrolment plugin.',
            'notifyerror'
        );
        return false;
    }

    // Add required persistent columns.
    if ($oldversion < 2018092106) {
        $admin = get_admin();

        // Add information fields to enrol_arlo_contact table.
        $table = new xmldb_table('enrol_arlo_contact');
        // Conditionally launch add field firstname.
        $field = new xmldb_field('firstname', XMLDB_TYPE_CHAR, '64', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally launch add field lastname.
        $field = new xmldb_field('lastname', XMLDB_TYPE_CHAR, '64', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally launch add field email.
        $field = new xmldb_field('email', XMLDB_TYPE_CHAR, '128', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally launch add field codeprimary.
        $field = new xmldb_field('codeprimary', XMLDB_TYPE_CHAR, '50', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally launch add field phonework.
        $field = new xmldb_field('phonework', XMLDB_TYPE_CHAR, '128', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally launch add field phonemobile.
        $field = new xmldb_field('phonemobile', XMLDB_TYPE_CHAR, '128', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally launch add field sourcestatus.
        $field = new xmldb_field('sourcestatus', XMLDB_TYPE_CHAR, '10', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally launch add field userassociationfailure.
        $field = new xmldb_field('userassociationfailure', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally rename field lasterror.
        $field = new xmldb_field('lasterror', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if ($dbman->field_exists($table, $field)) {
            // Launch rename field lasterror.
            $dbman->rename_field($table, $field, 'errormessage');
        }
        // Conditionally rename field errorcount and change precision.
        $field = new xmldb_field('errorcount', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        if ($dbman->field_exists($table, $field)) {
            // Launch change of precision for field errorcount.
            $dbman->change_field_precision($table, $field);
            // Launch rename field errorcount.
            $dbman->rename_field($table, $field, 'errorcounter');
        }
        // Conditionally launch drop field lastpulltime.
        $field = new xmldb_field('lastpulltime');
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Add/rename information fields on enrol_arlo_emailqueue.
        $table = new xmldb_table('enrol_arlo_emailqueue');
        $field = new xmldb_field('area', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, null);
        // Conditionally launch add field area.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Rename field enrolid on table enrol_arlo_emailqueue to instanceid.
        $field = new xmldb_field('enrolid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        // Launch rename field enrolid.
        if ($dbman->field_exists($table, $field)) {
            $dbman->rename_field($table, $field, 'instanceid');
        }

        // Add/rename information fields on enrol_arlo_registration table.
        $table = new xmldb_table('enrol_arlo_registration');
        $field = new xmldb_field('enrolmentfailure', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        // Conditionally launch add field enrolmentfailure.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally launch add field timelastrequest.
        $field = new xmldb_field('timelastrequest', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Conditionally rename field lasterror.
        $field = new xmldb_field('lasterror', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if ($dbman->field_exists($table, $field)) {
            // Launch rename field lasterror.
            $dbman->rename_field($table, $field, 'errormessage');
        }
        // Conditionally rename field errorcount and change precision.
        $field = new xmldb_field('errorcount', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        if ($dbman->field_exists($table, $field)) {
            // Launch change of precision for field errorcount.
            $dbman->change_field_precision($table, $field);
            // Launch rename field errorcount.
            $dbman->rename_field($table, $field, 'errorcounter');
        }
        // Conditionally launch drop field updateinternal.
        $field = new xmldb_field('updateinternal');
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }
        // Conditionally launch drop field lastpulltime.
        $field = new xmldb_field('lastpulltime');
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }
        // Conditionally launch drop field lastpulltime.
        $field = new xmldb_field('lastpushtime');
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Add required fields to appropriate tables for persistent support.
        $tablenames = [
            'enrol_arlo_contact',
            'enrol_arlo_emailqueue',
            'enrol_arlo_event',
            'enrol_arlo_onlineactivity',
            'enrol_arlo_registration',
            'enrol_arlo_template',
            'enrol_arlo_templateassociate'
        ];
        foreach ($tablenames as $tablename) {
            // Define field usermodified to be added to table.
            $table = new xmldb_table($tablename);
            $field = new xmldb_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            // Conditionally launch add field usermodified.
            if (!$dbman->field_exists($table, $field)) {
                $dbman->add_field($table, $field);
            }
            // Define field timecreated to be added to table.
            $table = new xmldb_table($tablename);
            $field = new xmldb_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            // Conditionally launch add field timecreated.
            if (!$dbman->field_exists($table, $field)) {
                $dbman->add_field($table, $field);
            }
            // Rename field modified on table to timemodified.
            $table = new xmldb_table($tablename);
            $field = new xmldb_field('modified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            // Conditionally rename field modified.
            if ($dbman->field_exists($table, $field)) {
                $dbman->rename_field($table, $field, 'timemodified');
            }
            // Update usermodified and timecreated.
            foreach ($DB->get_records($tablename) as $record) {
                $record->usermodified = $admin->id;
                $record->timecreated = $record->timemodified;
                $DB->update_record($tablename, $record);
            }
        }

        // Conditionally add enrol_arlo_scheduled_job table.
        if (!$dbman->table_exists('enrol_arlo_scheduledjob')) {
            $table = new xmldb_table('enrol_arlo_scheduledjob');
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('platform', XMLDB_TYPE_CHAR, '128', null, null, null, null);
            $table->add_field('area', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, null);
            $table->add_field('type', XMLDB_TYPE_CHAR, '40', null, XMLDB_NOTNULL, null, null);
            $table->add_field('instanceid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('collection', XMLDB_TYPE_CHAR, '40', null, XMLDB_NOTNULL, null, null);
            $table->add_field('endpoint', XMLDB_TYPE_CHAR, '128', null, XMLDB_NOTNULL, null, null);
            $table->add_field('lastsourceid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('lastsourcetimemodified', XMLDB_TYPE_CHAR, '36', null, XMLDB_NOTNULL, null, null);
            $table->add_field('timelastrequest', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('timenextrequestdelay', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('timenorequestsafter', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('timerequestsafterextension', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('errormessage', XMLDB_TYPE_TEXT, null, null, null, null, null);
            $table->add_field('errorcounter', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('disabled', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            // Primary key.
            $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
            $dbman->create_table($table);
        }

        // Conditionally add enrol_arlo_contactmerge table.
        if (!$dbman->table_exists('enrol_arlo_contactmerge')) {
            $table = new xmldb_table('enrol_arlo_contactmerge');
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('platform', XMLDB_TYPE_CHAR, '128', null, XMLDB_NOTNULL, null, null);
            $table->add_field('sourceid', XMLDB_TYPE_CHAR, '36', null, null, null, null);
            $table->add_field('sourcecontactid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('sourcecontactguid', XMLDB_TYPE_CHAR, '36', null, null, null, null);
            $table->add_field('destinationcontactid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('destinationcontactguid', XMLDB_TYPE_CHAR, '36', null, null, null, null);
            $table->add_field('sourcecreated', XMLDB_TYPE_CHAR, '36', null, null, null, null);
            $table->add_field('sourceuserid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('destinationuserid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('active', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
            $table->add_field('mergefailed', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            // Primary key.
            $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
            $dbman->create_table($table);
        }

        // Register site level jobs.
        \enrol_arlo\local\job\job::register_site_level_scheduled_jobs();

        // Migrate schedule information and instance information.
        $scheduletable = new xmldb_table('enrol_arlo_schedule');
        $instancetable = new xmldb_table('enrol_arlo_instance');
        if ($dbman->table_exists($scheduletable) && $dbman->table_exists($instancetable)) {
            $schedules = $DB->get_records('enrol_arlo_schedule', ['resourcetype' => 'registrations']);
            foreach ($schedules as $schedule) {
                $enrol = $DB->get_record('enrol', ['id' => $schedule->enrolid, 'enrol' => 'arlo']);
                if (!$enrol) {
                    continue;
                }
                $instance = $DB->get_record('enrol_arlo_instance', ['enrolid' => $schedule->enrolid]);
                if (!$instance) {
                    continue;
                }
                // Platform.
                $enrol->customchar1 = $instance->platform;
                // Type.
                $enrol->customchar2 = $instance->type;
                // Source GUID.
                $enrol->customchar3 = $instance->sourceguid;
                // Update enrolment instance record.
                $DB->update_record('enrol', $enrol);

                if ($instance->type == enrol_arlo\local\enum\arlo_type::EVENT) {
                    $endpoint = 'events/' . $instance->sourceid . '/registrations/';
                    $collection = 'Events';
                    $persistent = enrol_arlo\local\persistent\event_persistent::get_record(
                        ['sourceguid' => $instance->sourceguid]
                    );
                    if (!$persistent) {
                        continue;
                    }
                }
                if ($instance->type == enrol_arlo\local\enum\arlo_type::ONLINEACTIVITY) {
                    $endpoint = 'onlineactivities/' . $instance->sourceid . '/registrations/';
                    $collection = 'OnlineActivities';
                    $persistent = enrol_arlo\local\persistent\online_activity_persistent::get_record(
                        ['sourceguid' => $instance->sourceguid]
                    );
                    if (!$persistent) {
                        continue;
                    }
                }
                // Get end request time.
                $timenorequestsafter = $persistent->get_time_norequests_after();
                // Create enrolment/memberships scheduled job for this enrolment instance.
                $membershipsjob = enrol_arlo\local\job\job::register_scheduled_job(
                    'enrolment',
                    'memberships',
                    $enrol->id,
                    $endpoint,
                    $collection,
                    $timenorequestsafter
                );
                $membershipsjob->set('lastsourcetimemodified', $schedule->latestsourcemodified);
                $membershipsjob->set('lastsourceid', $schedule->lastsourceid);
                $membershipsjob->set('timelastrequest', $schedule->lastpulltime);
                $membershipsjob->set('timenextrequestdelay', enrol_arlo\local\job\job::TIME_PERIOD_DELAY);
                $membershipsjob->set('timerequestsafterextension', enrol_arlo\local\job\job::TIME_PERIOD_EXTENSION);
                $membershipsjob->set('errormessage', $schedule->lasterror);
                $membershipsjob->set('errorcounter', $schedule->errorcount);
                $membershipsjob->save();
                // Create outcomes scheduled job for this enrolment instance.
                $outcomesjob = enrol_arlo\local\job\job::register_scheduled_job(
                    'enrolment',
                    'outcomes',
                    $enrol->id,
                    'registrations/',
                    'Registrations',
                    $timenorequestsafter
                );
                $outcomesjob->set('timelastrequest', $schedule->lastpushtime);
                $outcomesjob->set('timenextrequestdelay', enrol_arlo\local\job\job::TIME_PERIOD_DELAY);
                $outcomesjob->set('timerequestsafterextension', enrol_arlo\local\job\job::TIME_PERIOD_EXTENSION);
                $outcomesjob->save();
                // Create update contacts info scheduled job for this enrolment instance.
                $contactsjob = enrol_arlo\local\job\job::register_scheduled_job(
                    'enrolment',
                    'contacts',
                    $enrol->id,
                    $endpoint,
                    $collection,
                    $timenorequestsafter

                );
                $contactsjob->set('timenextrequestdelay', enrol_arlo\local\job\contacts_job::TIME_PERIOD_DELAY);
                $contactsjob->set('timerequestsafterextension', enrol_arlo\local\job\contacts_job::TIME_PERIOD_EXTENSION);
                $contactsjob->save();
            }

            // Drop schedule table.
            $dbman->drop_table($scheduletable);

            // Drop instance table.
            $dbman->drop_table($instancetable);
        }

        // Migrate email queue data.
        $rs = $DB->get_recordset('enrol_arlo_emailqueue');
        foreach ($rs as $record) {
            if ($record->type == "newaccount") {
                $record->area = 'site';
                $record->instanceid = SITEID;
            } else {
                $record->area = 'enrolment';
            }
            $DB->update_record('enrol_arlo_emailqueue', $record, true);
        }
        $rs->close();

        // Conditionally drop templatelink table.
        $templatelinktable = new xmldb_table('enrol_arlo_templatelink');
        if ($dbman->table_exists($templatelinktable)) {
            $dbman->drop_table($templatelinktable );
        }

        // Arlo savepoint reached.
        upgrade_plugin_savepoint(true, 2018092106, 'enrol', 'arlo');
    }

    return true;
}
