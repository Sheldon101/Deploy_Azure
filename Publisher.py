import tweepy
import time
from keys import * 
# import Keys from keys.py

#Auth With Tweepy
auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
auth.set_access_token(ACCESS_KEY, ACCESS_SECRET)
api = tweepy.API(auth)

# File used to store last used or retrieved id
FILE_NAME = 'old_id.txt'
