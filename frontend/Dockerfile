# Use an official Node.js runtime as a parent image
FROM node:14-alpine

# Set the working directory for the container
WORKDIR /app

# Copy the package.json and package-lock.json files from the project to the container
COPY package*.json ./

# Install dependencies in the container
RUN npm install

# Copy the rest of the project files to the container
COPY . .

# Build the Next.js application inside the container
RUN npm run build

# Expose the port that the Next.js application will run on
EXPOSE 3000

# Set the command to run when the container starts
CMD ["npm", "start"]