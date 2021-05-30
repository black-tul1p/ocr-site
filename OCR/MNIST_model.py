import matplotlib as mpl
import matplotlib.pyplot as plt
import numpy as np
from torchvision import torch, transforms
import torch.nn as nn
import torch.nn.functional as fnc
from tqdm.notebook import tqdm

## Global variables
image_size = 28*28
num_classes = 10
batch = 100
debug = False

## Class that defines the LR model
class MNIST_Model(nn.Module):
	def __init__(self):
		super().__init__()
		self.linear=nn.Linear(image_size, num_classes)

	def forward(self, image):
		image = image.reshape(-1, 784)
		output = self.linear(image)
		return output

	def training_step(self, batch):
		images, labels = batch
		output = self(images)
		loss = fnc.cross_entropy(output, labels)
		return loss
	
	def validation_step(self, batch):
		images, labels=batch
		output = self(images)
		loss = fnc.cross_entropy(output, labels)
		acc = get_accuracy(output, labels)
		return {'val_loss': loss, 'val_acc': acc}
	
	def validation_epoch_end(self, output):
		batch_losses=[x['val_loss'] for x in output]
		epoch_loss=torch.stack(batch_losses).mean()
		batch_accs=[x['val_acc'] for x in output]
		epoch_acc=torch.stack(batch_accs).mean()
		return {'val_loss':epoch_loss.item(), 'val_acc':epoch_acc.item()}
	
	def epoch_end(self, epoch, result):
		print("Epoch [{}], val_loss={:.4f}, val_acc={:.4f}".format(epoch, result['val_loss'], result['val_acc']))

## Helper functions

# Calculate gradient values using Stochastic Gradient Descent
def get_gradient(epochs, model, lr, train_loader, test_loader):
	optimizer = torch.optim.SGD(model.parameters(), lr)
	for epoch in tqdm(range(epochs), desc='Training progress'):
		for batch in train_loader:
			loss = model.training_step(batch)
			loss.backward()
			optimizer.step()
			optimizer.zero_grad()
		# Validation of predictions for epoch
		result = compare(model, test_loader)
		if debug == True:
			model.epoch_end(epoch, result)

# Get % accuracy of predictions
def get_accuracy(output, labels):
	_, predictions = torch.max(output, dim=1)
	return torch.tensor(torch.sum(predictions == labels).item()/len(predictions))

# Validates predictions
def compare(model, test_loader):
	out=[model.validation_step(batch) for batch in test_loader]
	return model.validation_epoch_end(out)

# Returns prediction for given image
def predict(image, model):
	xb=image.unsqueeze(0)
	yb=model(xb)
	_, preds=torch.max(yb, dim=1)
	return preds[0].item()