"""
Publisher

notes:
pip install tweepy
"""

import datetime
import os  # to get the file path
import tweepy

import config  # secrets; not pushed to repository
import constants

MINUTES = 10  # minutes between reply posts


time_file = constants.TRANSCRIBER_TEXT_FILE_TIME  # file used to store last used or retrieved id
msg_file = constants.TRANSCRIBER_TEXT_FILE

# secrets; not pushed to repository
api_key = config.API_KEY
api_key_secret = config.API_KEY_SECRET
bearer_token = config.BEARER_TOKEN
access_token = config.ACCESS_TOKEN
access_token_secret = config.ACCESS_TOKEN_SECRET

# connect to client
client = tweepy.Client(bearer_token, api_key, api_key_secret, access_token, access_token_secret)

# authorize to use tweepy functions
auth = tweepy.OAuthHandler(api_key, api_key_secret, access_token, access_token_secret)
api = tweepy.API(auth)


def write_record(time_stamp):
    """Writes the time into the old id file when nothing exist in file.

    :param time_stamp: time stamp
    :return: void
    """
    f_write = open(time_file, 'w')
    f_write.write(str(time_stamp))
    f_write.close()
    return


def record(file):
    """
    :param file: file path
    :return: true if the file contains a recorder, false otherwise
    """
    if os.stat(file).st_size == 0:
        print("No Record")
        return False
    else:
        print("There is a Record")
        return True


def generate_time():
    now = datetime.datetime.now()
    # military time after 12 keep counting 1-> 13, 2->14, 3->15
    date_time = now.strftime("%Y-%m-%d %H:%M:%S")
    return date_time


def spilt_date_time(date_w_space):
    # date string
    sliced_object = slice(10)
    sliced_date = date_w_space[sliced_object]
    # time string
    sliced_object_with_start = slice(11, 19)
    sliced_time = date_w_space[sliced_object_with_start]
    # return as separate
    return sliced_date, sliced_time


def compare_dates(n_date1, n_date2):
    # Convert date strings to datetime objects
    date1 = datetime.datetime.strptime(n_date1, "%Y-%m-%d")
    date2 = datetime.datetime.strptime(n_date2, "%Y-%m-%d")
    # Compare the datetime objects
    if date1 < date2:
        return True
    return False


def compare_times(n_time1, n_time2):
    # convert time string to datetime
    print("same day, checking for time")
    t1 = datetime.datetime.strptime(n_time1, "%H:%M:%S")
    print('old post time:', t1.time())
    t2 = datetime.datetime.strptime(n_time2, "%H:%M:%S")
    print('new post time:', t2.time())
    # determine whether diff of time
    elapsed = t2 - t1
    if elapsed > datetime.timedelta(minutes=MINUTES):
        print("exceed time limit, new post")
        reply_status = False
    elif t1.time() == t2.time():
        print("same time, reply")
        reply_status = True
    else:
        print("within time limit, repy")
        reply_status = True
    return reply_status


def replace_time(old_time, new_time):
    """Replace old time with new time inside the record.

    :param old_time: original time of post
    :param new_time: updated time of post
    :return: old_time
    """
    with open(time_file, 'r') as f:
        data = f.read()
        data = data.replace(old_time, new_time)
    with open(time_file, 'w') as f:
        f.write(data)
    return old_time


def read_file(filename):
    with open(filename, 'r') as f:
        text = f.read()
    return text


def tweet(message: str):
    client.create_tweet(text=message)
    print("tweet is now in twitter")


def run():
    # Task: determine if we have a file for message
    text_in_file = record(msg_file)
    if text_in_file:
        record_in_file = record(time_file)
        if not record_in_file:
            time_post = generate_time()
            write_record(time_post)
            message = read_file(msg_file)
            tweet(message)
        else:
            msg_in_file = read_file(msg_file)
            old_post_s_char = read_file(time_file)
            new_s_char = generate_time()
            reference_time = replace_time(old_post_s_char, new_s_char)
            n_date1, n_time1 = spilt_date_time(old_post_s_char)
            print("Date of old record:", n_date1)
            print("Time of old record:", n_time1)
            new_post_s_char = generate_time()
            n_date2, n_time2 = spilt_date_time(new_post_s_char)
            print("Date of new record:", n_date2)
            print("Time of new record:", n_time2)
            is_new_post_older = compare_dates(n_date1, n_date2)
            if not is_new_post_older:
                print("might be a reply check time now")
                reply_to_post = compare_times(n_time1, n_time2)
                if reply_to_post:
                    print(" reply, add timestamp to the tweet")
                    time_stamp = "\n[\'reply\' to: " + reference_time + "]"
                    message = msg_in_file + time_stamp
                    print(message)
                    tweet(message)
                else:
                    print("a new post")
                    message = msg_in_file
                    tweet(message)
            else:
                print("just tweet a new post, day(s) late")
                message = msg_in_file
                tweet(message)
    else:
        print("No transmission in file")

# end of publisher
