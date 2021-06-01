from image_edit import convert_bnw, resize_img, to_float_tensor
from MNIST_model import MNIST_Model, predict
from torchvision import torch
import os, sys, random

# Displays logo
def logo():
	print(r'''
	 ________  ___  ________  ___  _________        ________  ________  ________     
	|\   ___ \|\  \|\   ____\|\  \|\___   ___\     |\   __  \|\   ____\|\   __  \    
	\ \  \_|\ \ \  \ \  \___|\ \  \|___ \  \_|     \ \  \|\  \ \  \___|\ \  \|\  \   
	 \ \  \ \\ \ \  \ \  \  __\ \  \   \ \  \       \ \  \\\  \ \  \    \ \   _  _\  
	  \ \  \_\\ \ \  \ \  \|\  \ \  \   \ \  \       \ \  \\\  \ \  \____\ \  \\  \| 
	   \ \_______\ \__\ \_______\ \__\   \ \__\       \ \_______\ \_______\ \__\\ _\ 
	    \|_______|\|__|\|_______|\|__|    \|__|        \|_______|\|_______|\|__|\|__|
	                                                                    ~ black-tul1p
	''')

# Main function
def main():
	# Parse arguments
	if len(sys.argv) != 2:
		raise Exception("Incorrect arguments provided\nUsage:\tpython {}".format(sys.argv[0])+
			" <path-to-img>")
	image_path = sys.argv[1]
	if image_path == "":
		raise Exception("Image not found or not accessible")

	# # Read and modify image for analysis
	# converted_img = convert_bnw(image_path)
	out_path = os.path.join(".", "OCR", "bnw_images", str(random.randint(1,65535))+".png")
	convert_bnw(image_path, out_path)

	# Resize and convert image to Tensor for analysis
	input_im = resize_img(out_path)
	input_im = to_float_tensor(input_im)

	# Load existing model if requested
	lr_model = MNIST_Model()
	lr_model.load_state_dict(torch.load(os.path.join(".", "OCR","mnist-digit-ocr.pth")))
	print('The digit in the image is:', predict(input_im, lr_model))

# Calling main
if __name__=="__main__":
	main()
