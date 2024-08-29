from flask import Flask, request, jsonify
import librosa
import librosa.display
import matplotlib.pyplot as plt
import numpy as np
from keras.models import load_model
from PIL import Image
from tensorflow.keras.preprocessing import image

global px, model, class_dict
# model = load_model('SP_32_0001_relu-soft_05_fadmov.keras')
model = load_model('C:\laragon\www\cnn-predict\py-app\SP_32_0001_relu-soft_05_7343_newpict.keras')
print('model loaded')
# model = load_model('MEL_incep_no_gen_ES_adam_001.h5',  compile=False)
px = 1/plt.rcParams['figure.dpi']
class_dict = {0: 'healthy',1: 'positive',2: 'recovered'}

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def index():
    file = request.files['file']
    filename = file.filename.split('.')[0]

    y, sr = librosa.load(file)
    dur = librosa.get_duration(y=y, sr=sr)
    if dur > 10:
        return jsonify({
            'message' : 'Duration cannot be above 5 second',
        }), 422

    if not len(np.unique(y)) <= 1:
        mel_spectrogram = librosa.feature.melspectrogram(y=y, sr=sr, fmax=sr/2)
        mel_spectrogram_db = librosa.power_to_db(mel_spectrogram, ref=np.max)

        plt.figure(figsize=(343*px, 324*px))
        librosa.display.specshow(mel_spectrogram_db, sr=sr, y_axis='mel', x_axis='time', fmax=sr/2)
        # plt.colorbar()
        plt.tight_layout()
        plt.ylabel("")
        # plt.show()
        # print('checkpoint')

        output_image_path = f'C:/laragon/www/cnn-predict/public/data/{filename}.png'
        # output_image_path = f'../public/data/{filename}.png'
        plt.savefig(output_image_path, bbox_inches='tight', pad_inches=0.03)
        plt.clf()
        plt.close()

        print(f"MELspectrogram saved as '{output_image_path}'")

        test_image = image.load_img(output_image_path, target_size = (299, 299))
        test_image = image.img_to_array(test_image)
        test_image = np.expand_dims(test_image, axis = 0)

        #predict the result
        result = model.predict([test_image])
        result2 = np.argmax(result, axis= -1)
        percentage = np.round(result*100, decimals=1)
        print(percentage)
        print(percentage.tolist())
        # print(f'Result axis: {result[0]}')
        # print(f'Result dict: {class_dict[result[0]]}')
    else:
        return jsonify({
            'message' : 'Audio is empty, try other file or re-record',
        }), 422


    return jsonify({
        'data' : {
            'result' : class_dict[result2[0]],
            'percentage': percentage[0].tolist(),
            'file': filename,
        }
    }), 200

if __name__ == '__main__':
    app.run(debug=True)

###   run the app
#   flask --app app run