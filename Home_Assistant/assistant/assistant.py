# import necessary packages
from __future__ import print_function
import sys
import os
from sense_hat import SenseHat
import aiy.assistant.auth_helpers
from aiy.assistant.library import Assistant
import aiy.audio
import aiy.voicehat
from google.assistant.library.event import EventType
import platform
import subprocess
from datetime import datetime
from datetime import timedelta
from googleapiclient.discovery import build
from httplib2 import Http
from oauth2client import file, client, tools
from oauth2client.client import OAuth2WebServerFlow
import datetime, timeago
import time
import math

sense = SenseHat()
service = None

# init google calendar
def init_calendar():
    global service
    SCOPES = 'https://www.googleapis.com/auth/calendar'
    store = file.Storage('token.json')
    creds = store.get()
    if not creds or creds.invalid:
        flow = OAuth2WebServerFlow(client_id='15422647756-2isa7hl7ii6qfv94liid991taoldbfmb.apps.googleusercontent.com', client_secret='W492jqNRq6YArRbGvHh4tz80', scope=SCOPES)
        creds = tools.run_flow(flow, store)
    service = build('calendar', 'v3', http=creds.authorize(Http()))


# make an appointment
def set_appointment(title, start):
    global service
    global sense
    try:
        init_calendar()
        i = datetime.datetime.now()
        event = {
            'summary': title,
            'location': 'RMIT',
            'description': title,
            'start': { 
                "dateTime": (i + timedelta(days=int(start[0:2]))).strftime('%Y-%m-%dT%H:%M:%S'),
                "timeZone": "Australia/Melbourne"
            },
            'end': { 
                "dateTime": (i + timedelta(days=int(start[0:2]), minutes=60)).strftime('%Y-%m-%dT%H:%M:%S'),
                "timeZone": "Australia/Melbourne"
            },
            'attendees': [
                {'email': 'mrjasonedu@gmail.com'},
            ],
            'reminders': {
                'useDefault': False,
                'overrides': [
                    {'method': 'email', 'minutes': 24 * 60},
                    {'method': 'popup', 'minutes': 10},
                ],
            },
        }
        event = service.events().insert(calendarId='mrjasonedu@gmail.com', body=event).execute()
        aiy.audio.say("Successfully added!")
    except Exception as e:
        aiy.audio.say("Please try again")

def process_event(assistant, event):
    """
    Process event
    :param assistant: assistant object
    :param event: event object
    :return: None
    """
    status_ui = aiy.voicehat.get_status_ui()
    if event.type == EventType.ON_START_FINISHED:
        status_ui.status('ready')
        if sys.stdout.isatty():
            print('Say "OK, Google" then speak, or press Ctrl+C to quit...')

    elif event.type == EventType.ON_CONVERSATION_TURN_STARTED:
        status_ui.status('listening')

    elif event.type == EventType.ON_RECOGNIZING_SPEECH_FINISHED and event.args:
        print('You said:', event.args['text'])
        text = event.args['text'].lower()
        if text.find('make an appointment') != -1:
            # make an appointment to study cloud computing in two days
            assistant.stop_conversation()
            event = text[23:text.rfind('in')]
            start = text[text.rfind('in') + 3:]
            set_appointment(event, start)

    elif event.type == EventType.ON_END_OF_UTTERANCE:
        status_ui.status('thinking')

    elif (event.type == EventType.ON_CONVERSATION_TURN_FINISHED
          or event.type == EventType.ON_CONVERSATION_TURN_TIMEOUT
          or event.type == EventType.ON_NO_RESPONSE):
        status_ui.status('ready')

    elif event.type == EventType.ON_ASSISTANT_ERROR and event.args and event.args['is_fatal']:
        sys.exit(1)

def main():
    """
    Main function
    :return: None
    """
    if platform.machine() == 'armv6l':
        print('Cannot run hotword demo on Pi Zero!')
        exit(-1)

    credentials = aiy.assistant.auth_helpers.get_assistant_credentials()
    with Assistant(credentials) as assistant:
        for event in assistant.start():
            process_event(assistant, event)


if __name__ == '__main__':
    main()
