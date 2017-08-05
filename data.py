#!/usr/bin/env python
from copy import copy, deepcopy
import MySQLdb
import matplotlib
#matplotlib.use('Agg')
import numpy
import math
import matplotlib.pyplot as plt
from datetime import datetime
from matplotlib.legend_handler import HandlerLine2D
import sys
import csv
import os
from random import randint

db = MySQLdb.connect( 'credentials')

cursor=db.cursor()

cursor.execute("SELECT cf_id,cf_user_id, AVG(ad_valence) as ad_valence FROM content_feedback cf  join content c on cf.cf_c_id=c.c_id  join `analysis_results` ar on ar.ar_cf_id= cf.cf_id join `analysis_detail_premium_v2` ad on ad.ad_ar_id=ar.ar_id WHERE  cf.cf_total_feedback_v2>=c.c_duration   group by cf_id ORDER BY cf_user_id")

result = cursor.fetchall()
result = numpy.array(result)
cursor.execute("SELECT DISTINCT cf_user_id FROM content_feedback cf  join content c on cf.cf_c_id=c.c_id  join `analysis_results` ar on ar.ar_cf_id= cf.cf_id join `analysis_detail_premium_v2` ad on ad.ad_ar_id=ar.ar_id WHERE  cf.cf_total_feedback_v2>=c.c_duration   group by cf_id ORDER BY cf_user_id")

user=cursor.fetchall()
user = numpy.array(user)
cursor.execute("SELECT DISTINCT cf_id FROM content_feedback cf  join content c on cf.cf_c_id=c.c_id  join `analysis_results` ar on ar.ar_cf_id= cf.cf_id join `analysis_detail_premium_v2` ad on ad.ad_ar_id=ar.ar_id WHERE  cf.cf_total_feedback_v2>=c.c_duration   group by cf_id")

video=cursor.fetchall()
video = numpy.array(video)
rows=len(user)
col=len(video)

data=numpy.zeros((rows,col))

i=0
prev=user[0]


for row in result:
  if(row[1]!=prev) and i < rows-1:
    i=i+1
  j=0
  while(True):
    if row[0]==video[j] or (j == col -1):
      #print 'matched'
      break
    j=j+1
  #print j
  t= row[2]
  data[i][j] = t


u = numpy.random.rand(rows,2)
v = numpy.random.rand(col,2)

sigmau=[]
sigmav=[]

for row in data:
	sigmau.append(numpy.nonzero(row)[0])

datat=data.transpose()


for row in datat:
	sigmav.append(numpy.nonzero(row)[0])

#updating u
Lu = .005
Lv = .005
# fig=plt.figure(2)

# plt.ion()




for itr in range(0,500):
  for n in range(0,len(u)):
    k=len(sigmau[n])
    t = randint(0,k-1)
    m = sigmau[n][t]
    u[n]= u[n] - .1*(Lu*u[n] - (data[n][m] - numpy.dot(u[n],v[m]))*v[m])

  for m in range(0,len(v)):
    k=len(sigmav[m])
    t = randint(0,k-1)
    n = sigmav[m][t]
    v[m]= v[m] - .1*(Lu*v[m] - (data[n][m] - numpy.dot(v[m],u[n]))*u[n])
  print itr
  #print u
  #print v
  e=0
  if itr==499:
    pred = numpy.matmul(u,v.transpose())
    c = 0
    s=0
    for i in range(0,rows):
      for j in range(0,col):
        if data[i][j] != float(0):
          c=c+1
          s = s + math.fabs((data[i][j] - pred[i][j])/data[i][j])*100
    e = s/c
    print e
  #   plt.scatter(itr,e,color = 'r')
  #   plt.pause(0.05)

  # print itr,e
# plt.show()
pred = numpy.matmul(u,v.transpose())

# fig=plt.figure(1)
# plt.scatter(u[:,1],u[:,0])
# plt.scatter(v[:,1],v[:,0],color = 'r')
# plt.show()
c_id = []
for item in video:
  item = int(item[0])
  cursor.execute("SELECT cf_c_id FROM `content_feedback` WHERE cf_id=%d"%item)
  t = cursor.fetchone()
  c_id.append(int(t[0]))

vid_show = []
index = 0
for i in range(0,rows):
  max = 0
  for j in range(0,col):
    if(data[i][j] == float(0)):
      if pred[i][j] > max:
        max = pred[i][j]
        index = j
  vid_show.append(c_id[index])

with open('prediction.csv', 'wb') as file:
  w = csv.writer(file)
  w.writerow(["users",video])
  i=0
  for row in pred:
    w.writerow([user[i],row])
    i=i+1
