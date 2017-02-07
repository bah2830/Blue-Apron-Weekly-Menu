FROM golang:latest

COPY . /go/src/github.com/bah2830/Blue-Apron-Weekly-Menu

WORKDIR /go/src/github.com/bah2830/Blue-Apron-Weekly-Menu

RUN go get
RUN go build -o /app/Blue-Apron-Weekly-Menu

EXPOSE 8080

CMD ["/app/Blue-Apron-Weekly-Menu"]
