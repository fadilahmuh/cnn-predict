import matplotlib.pyplot as plt
import numpy as np
import keras
from PIL import Image

model = keras.saving.load_model('SP_32_0001_relu-soft_05.h5', compile=False)
# model = keras.layers.TFSMLayer("SP_32_0001_relu-soft_05.h5")

print(model)