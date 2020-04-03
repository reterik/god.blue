#sudo python3 run.py evaluate -s /home/reterik/model6 experiments/newsgroups_without_cuda.json
#sudo python3 run.py evaluate experiments/newsgroups_without_cuda.json
#sudo python3 -m allennlp.run evaluate https://s3-us-west-2.amazonaws.com/allennlp/models/bidaf-model-2017.09.15-charpad.tar.gz https://s3-us-west-2.amazonaws.com/allennlp/datasets/squad/squad-dev-v1.1.json
#sudo python3 run.py evaluate /home/reterik/model4 https://s3-us-west-2.amazonaws.com/allennlp/datasets/squad/squad-train-v1.1.json
#sudo python3 run.py find-lr -s /home/reterik/model4 --recover experiments/newsgroups_without_cuda.json
#sudo python3 run.py evaluate /home/reterik/model7 experiments/newsgroups_without_cuda.json
#sudo python3 run.py find-lr experiments/newsgroups_without_cuda.json /home/reterik/model4/model.tar.gz
#sudo python3 run.py find-lr experiments/newsgroups_without_cuda.json -s /home/reterik/model4
#sudo python3 run.py find-lr /home/reterik/model4/model.tar.gz -s model1
#sudo python3 run.py evaluate /home/reterik/model4/model.tar.gz https://s3-us-west-2.amazonaws.com/allennlp/datasets/squad/squad-dev-v1.1.json
sudo python3 run.py find-lr /home/reterik/model4/model.tar.gz -s model1
