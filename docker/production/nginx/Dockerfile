FROM node:22-alpine AS builder

WORKDIR /app

COPY ../../../package*.json ./
RUN npm install

COPY . .

RUN npm run build

FROM nginx:1.28-alpine

COPY --from=builder /app/public /usr/share/nginx/html

COPY ./docker/production/nginx/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
