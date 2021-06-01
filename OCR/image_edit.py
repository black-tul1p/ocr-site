from PIL import Image
from torchvision import torch
import cv2

def convert_bnw(in_path, out_path):
	rgb_image = Image.open(in_path)
	bnw_image = rgb_image.convert('L')
	bnw_image.save(out_path)

def resize_img(img_path):
	input_im = cv2.imread(img_path)
	input_im = cv2.resize(input_im, (28, 28))
	return input_im

def to_float_tensor(np_array):
	return torch.from_numpy(np_array).float()