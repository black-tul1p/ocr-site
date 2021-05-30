from torchvision import torch
import cv2

def convert_bnw(in_path):
	bnw_image = cv2.imread(in_path, cv2.IMREAD_GRAYSCALE)
	return bnw_image

def resize_img(input_im):
	input_im = cv2.resize(input_im, (28, 28))
	return input_im

def to_float_tensor(np_array):
	return torch.from_numpy(np_array).float()