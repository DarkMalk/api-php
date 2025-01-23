<?php

enum StatusHTTP: int
{
  case OK = 200;
  case CREATED = 201;
  case NO_CONTENT = 204;
  case BAD_REQUEST = 400;
  case UNAUTHORIZED = 401;
  case NOT_FOUND = 404;
  case SERVER_ERROR = 500;
  case NOT_MODIFIED = 304;
}
