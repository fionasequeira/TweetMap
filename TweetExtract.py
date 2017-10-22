import json
import tweepy
from requests_aws4auth import AWS4Auth
from tweepy import Stream
from tweepy.streaming import StreamListener
from tweepy import OAuthHandler
import cgi
from boto.sqs.message import Message
from textwrap import TextWrapper
import requests
from elasticsearch import Elasticsearch, RequestsHttpConnection
import certifi
from aws_requests_auth.aws_auth import AWSRequestsAuth


consumer_key = 'YOUR_CONSUMER_KEY'
consumer_secret = 'YOUR_CONSUMER_SECRET'
access_token = 'YOUR_ACCESS_TOKEN'
access_secret = 'YOUR_ACCESS_SECRET'


auth = AWSRequestsAuth(aws_access_key='YOUR_ACCESS_KEY',
                       aws_secret_access_key='YOUR_SECRET_ACCESS_KEY',
                       aws_host='ELASTIC_SEARCH_ENDPOINT',
                       aws_region='REGION',
                       aws_service='es')

host = 'HOST_ENDPOINT'

es = Elasticsearch(
    hosts=[{'host': host, 'port': 443}],
    use_ssl=True,
    http_auth=auth,
    verify_certs=True,
    connection_class=RequestsHttpConnection
)
print (es.info())
#Authorizing the twitter acount
auth = OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_secret)

api = tweepy.API(auth)
count = 0
class TweetListener(StreamListener):  
    def on_data(self, data):
        try:
            status_wrapper = TextWrapper(width=60, initial_indent='    ', subsequent_indent='    ')
            twitter_data = json.loads(data)
            #print (data)
            m = Message()
            if ('coordinates' in twitter_data.keys()):
                if (twitter_data['coordinates'] is not None):
                    tweet = 
                    {
                        'id': twitter_data['id'],
                        'time': twitter_data['timestamp_ms'],
                        'text': twitter_data['text'].lower().encode('ascii', 'ignore').decode('ascii'),
                        'coordinates': twitter_data['coordinates'],
                        'place': twitter_data['place'],
                        'handle': twitter_data['user']['screen_name']
                    }

                    global count
                    count += 1
                    print (tweet)
                    print (count)
                    res = es.index(index="tweet", doc_type='tweet', body=tweet)
                    print(res)                   
                    return True
        except BaseException as e:
            print("Error on_data: %s" % str(e))
        return True

    def on_error(self, status):
        print(status)
        return True


twitter_stream = Stream(auth, TweetListener())
try:
    twitter_stream.filter(languages=["en"],track=['#trump','#cloud','#photo','#memories','#party','#birthday','#fun','#newyork'])
except (KeyError, TypeError):
    pass