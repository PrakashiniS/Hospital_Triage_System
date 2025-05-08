import sys
import pandas as pd
import joblib
import os

# Load values from sys.argv
try:
    temp = float(sys.argv[1])
    hr = int(sys.argv[2])
    bps = int(sys.argv[3])
    bpd = int(sys.argv[4])
except Exception as e:
    print(f"Error: Invalid input - {str(e)}", file=sys.stderr)
    sys.exit(1)

# File path
csv_path = 'app/models/patient_data.csv'

# New row to append
new_row = pd.DataFrame([[temp, hr, bps, bpd]], columns=["temperature", "heart_rate", "bp_systolic", "bp_diastolic"])

# Append to CSV
if os.path.exists(csv_path):
    df = pd.read_csv(csv_path)
    df = pd.concat([df, new_row], ignore_index=True)
else:
    df = new_row

# Save back to CSV
df.to_csv(csv_path, index=False)

# Load model
try:
    model = joblib.load('app/models/triage_model.pkl')
except Exception as e:
    print(f"Error loading model - {str(e)}", file=sys.stderr)
    sys.exit(1)

# Predict for latest row only
try:
    latest_input = df.tail(1)
    print(f"Input data for prediction: {latest_input}")  # Print input data
    triage = model.predict(latest_input)
    print(f"Prediction: {int(triage[0])}")  # Print prediction
except Exception as e:
    print(f"Error predicting - {str(e)}", file=sys.stderr)
    sys.exit(1)
