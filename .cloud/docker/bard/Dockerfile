# Use the official Python image from DockerHub
FROM python:3.9-slim

# Set the working directory inside the container
WORKDIR /app

# Copy the Python script and requirements file into the container
COPY . .

# Install the bardapi from the specified GitHub repository
RUN pip install --no-cache-dir bardapi

# Install other required Python packages
RUN pip install --no-cache-dir -r requirements.txt

# Set the command to run your Python script
CMD ["python", "/app/code/api.py"]
