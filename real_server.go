package main

import (

	//	"math"

	"database/sql"
	"fmt"
	"log"
	"net/http"

	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/cookie"
	"github.com/gin-gonic/gin"
	_ "github.com/mattn/go-sqlite3"
	"go.mongodb.org/mongo-driver/bson"
	//	"strings"
)

func setupRouter() *gin.Engine {
	r := gin.Default()
	store := cookie.NewStore([]byte("nlancalcaksalnfoedclacaslca"))
	store.Options(sessions.Options{
		MaxAge: 60 * 60,
	})
	r.Use(sessions.Sessions("barier", store))

	r.Static("/static_barier", "./static")
	r.LoadHTMLGlob("templates/*")

	db, err := sql.Open("sqlite3", "site.db")

	if err != nil {
		log.Fatal(err)
	}

	defer db.Close()

	run_q := "CREATE TABLE IF NOT EXISTS TABLE_NAME (column_name datatype, column_name datatype);"

	r.GET("/ping", func(c *gin.Context) {
		c.String(200, "pong")
	})

	r.GET("/index", func(c *gin.Context) {
		session := sessions.Default(c)
		fmt.Println("CEK SESSION DULU", session.Get("admin"))
		if session.Get("login") == "user" {
			data := bson.M{}
			data["data"] = "ok"
			c.HTML(http.StatusOK, "index.html", nil)
			return
		}
		c.Redirect(http.StatusFound, "/login")
		return
	})

	r.GET("/login", func(c *gin.Context) {
		session := sessions.Default(c)
		if session.Get("login") == "user" {
			data := bson.M{}
			data["data"] = "ok"
			c.JSON(http.StatusOK, data)
			return
		} else {
			c.HTML(http.StatusOK, "login.html", nil)
			return
		}
	})

	r.GET("/upload", func(c *gin.Context) {
		c.HTML(http.StatusOK, "upload.html", nil)
		return
	})

	r.POST("/upload", func(c *gin.Context) {
		title := c.PostForm("title")
		caption := c.PostForm("caption")
		img, err := c.FormFile("photo")
		if err != nil {
			c.String(http.StatusBadRequest, fmt.Sprintf("err: %s", err.Error()))
			return
		}
		fmt.Println("param", title, caption)
		fmt.Println("photo ->", img.Filename)
		if err := c.SaveUploadedFile(img, "./static/upload/"+img.Filename); err != nil {
			c.String(http.StatusBadRequest, fmt.Sprintf("err: %s", err.Error()))
			return
		}
	})

	r.GET("/", func(c *gin.Context) {
		session := sessions.Default(c)
		if session.Get("login") == "user" {
			data := bson.M{}
			data["data"] = "ok"
			c.JSON(http.StatusOK, data)
			return
		} else {
			c.Redirect(http.StatusFound, "/login")
			return
		}
	})

	r.POST("/login", func(c *gin.Context) {
		session := sessions.Default(c)
		if session.Get("login") == "user" {
			c.Redirect(http.StatusFound, "/index")
			//	c.HTML(http.StatusOK, "login.html", nil)
			//	session.Set("hello", "world")
			//	session.Save()
		} else {
			user := c.PostForm("user")
			password := c.PostForm("password")

			if (user != "user") && (password != "pass") {
				c.HTML(http.StatusOK, "login.html", nil)
			}
			session.Set("login", "user")
			session.Save()
			c.Redirect(http.StatusFound, "/index")
			c.Redirect(http.StatusFound, "/index")
		}
	})

	return r
}

func main() {
	r := setupRouter()
	r.Run(":7575")
}
