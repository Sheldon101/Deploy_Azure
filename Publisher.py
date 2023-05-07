# from old file 
from subprocess import call
import sys

#needed to publish tweet and reply 
import tweepy
from keys import * 
# import Keys from keys.py

#Auth With Tweepy
auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
auth.set_access_token(ACCESS_KEY, ACCESS_SECRET)
api = tweepy.API(auth)

# File used to store last used or retrieved id
id_file = 'old_id.txt'
#Put file on the transmission here 
file_name= '.txt'

def read_file(filename):
    with open(filename, 'r') as f:
        text = f.read()
    return text
  
# function needed to get the old_id 
def retrieve_old_id(id_file):
    f_read = open(id_file, 'r')
    old_id = int(f_read.read().strip())
    f_read.close()
    return old_id
  
#function that stores the old id so the same tweet is not always accessed 
def store_last_seen_id(old_id, id_file):
    f_write = open(old_id, 'w')
    f_write.write(str(id_file))
    f_write.close()
    return


def tweet(message: str):
        response = client.create_tweet(text=message)
        print(response.headers)
 
#reply to tweet only if it 
#1. a tweet exist
#2.  within the timestamp 

# Reply to the tweets
def reply_to_tweet():
  #add last seen id for running script from last endpoint
    old_id = retrieve_old_id(id_file)
        old_id = #get new value 
        store_last_seen_id(last_seen_id, FILE_NAME)
        # Replace 'Something' with a text you want to find
 # if we are replying neew to reply--> update.status()      
# the ID of the tweet to be replied to
#in_reply_to_status_id = ""
  
# posting the tweet
#api.update_status(status, in_reply_to_status_id)
           

  #old_code       
#def main():
 #   try:
  #      if (len(sys.argv) < 2):
   #         print("No file name given.")
    #        exit()
        
     #   message = read_file(sys.argv[1])
      #  tweet(message)
    #except KeyboardInterrupt:
     #   exit()

#if __name__ == "__main__":
 #   main()
