<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\utility
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

namespace open20\amos\events\utility;

/**
 * Source: https://gist.github.com/jakebellacera/635416
 *
 * ICS.php
 * =======
 * Use this class to create an .ics file.
 *
 * Usage
 * -----
 * Basic usage - generate ics file contents (see below for available properties):
 *   $ics = new ICS($props);
 *   $ics_file_contents = $ics->to_string();
 *
 * Setting properties after instantiation
 *   $ics = new ICS();
 *   $ics->set('summary', 'My awesome event');
 *
 * You can also set multiple properties at the same time by using an array:
 *   $ics->set(array(
 *     'dtstart' => 'now + 30 minutes',
 *     'dtend' => 'now + 1 hour'
 *   ));
 *
 * Available properties
 * --------------------
 * description
 *   String description of the event.
 * dtend
 *   A date/time stamp designating the end of the event. You can use either a
 *   DateTime object or a PHP datetime format string (e.g. "now + 1 hour").
 * dtstart
 *   A date/time stamp designating the start of the event. You can use either a
 *   DateTime object or a PHP datetime format string (e.g. "now + 1 hour").
 * location
 *   String address or description of the location of the event.
 * summary
 *   String short summary of the event - usually used as the title.
 * url
 *   A url to attach to the the event. Make sure to add the protocol (http://
 *   or https://).
 */

/**
 * Class EventsUtility
 * @package open20\amos\events\utility
 */
class ICS {
  const DT_FORMAT = 'Ymd\THis';

  protected $properties = array();
  private $available_properties = array(
    'description',
    'dtend',
    'dtstart',
    'location',
    'summary',
    'url'
  );

  public function __construct($props) {
    $this->set($props);
  }

  public function set($key, $val = false) {
    if (is_array($key)) {
      foreach ($key as $k => $v) {
        $this->set($k, $v);
      }
    } else {
      if (in_array($key, $this->available_properties)) {
        $this->properties[$key] = $this->sanitize_val($val, $key);
      }
    }
  }

  public function to_string() {
    $rows = $this->build_props();
    return implode("\r\n", $rows);
  }

  private function build_props() {
    // Build ICS properties - add header
    $ics_props = array(
      'BEGIN:VCALENDAR',
      'VERSION:2.0',
      'PRODID:-//hacksw/handcal//NONSGML v1.0//EN',
      'CALSCALE:GREGORIAN',
      'BEGIN:VEVENT'
    );

    // Build ICS properties - add header
    $props = array();
    foreach($this->properties as $k => $v) {
      $props[strtoupper($k . ($k === 'url' ? ';VALUE=URI' : ''))] = $v;
    }

    // Set some default values
    $props['DTSTAMP'] = $this->format_timestamp('now');
    $props['UID'] = uniqid();

    // Append properties
    foreach ($props as $k => $v) {
      $ics_props[] = "$k:$v";
    }

    // Build ICS properties - add footer
    $ics_props[] = 'END:VEVENT';
    $ics_props[] = 'END:VCALENDAR';

    return $ics_props;
  }

  private function sanitize_val($val, $key = false) {
    switch($key) {
      case 'dtend':
      case 'dtstamp':
      case 'dtstart':
        $val = $this->format_timestamp($val);
        break;
      default:
        $val = $this->escape_string($val);
    }

    return $val;
  }

  private function format_timestamp($timestamp) {
    $dt = new \DateTime($timestamp);
    $timezone = new \DateTimeZone('Europe/Rome');
    $dt->setTimezone($timezone);
    return $dt->format(self::DT_FORMAT);
  }

  private function escape_string($str) {
    return preg_replace('/([\,;])/','\\\$1', $str);
  }
}
